<?php

/**
 * @author Denis Utkin <dizirator@gmail.com>
 * @link   https://github.com/dizirator
 */

namespace setrun\sys\components;

use setrun\sys\helpers\FileHelper;
use Yii;
use yii\db\Query;
use yii\db\Connection;
use yii\caching\FileCache;
use setrun\sys\entities\Domain;
use setrun\sys\entities\Setting;
use setrun\sys\entities\Language;
use setrun\sys\helpers\ArrayHelper;
use yii\base\InvalidConfigException;
use setrun\sys\components\configurator\Storage;

/**
 * Class Configurator.
 */
class Configurator
{
    public const WEB        = 'application.web';
    public const CONSOLE    = 'application.console';
    public const COMPONENT  = 'component';

    /**
     * List of configurations application.
     * @var array
     */
    protected $appConfig = [];

    /**
     * Env state.
     * @var string
     */
    protected $env = self::WEB;

    /**
     * Object of cache.
     * @var FileCache
     */
    protected $cache = null;

    /**
     * Caching path.
     * @var string
     */
    protected $cachePath = '@app/runtime/cache_configurator';

    /**
     * @var Storage
     */
    protected $storage = null;

    /**
     * Set of env state.
     * @param string $env
     * @return void
     */
    public function setEnv(string $env) : void
    {
        $this->env = $env;
    }

    /**
     * Set of caching path.
     * @param string $path
     * @return void
     */
    public function setCachePath(string $path) : void
    {
        $this->cachePath = $path;
    }

    /**
     * Get a configuration of key.
     * @param null $key
     * @return Storage
     */
    public function component($key = null) : Storage
    {
        $this->getStorage()->clearKey();
        $storage = $this->getStorage()->addKey(self::COMPONENT);
        if ($key === null) {
            return $this->getStorage()->get();
        }
        return $storage->addKey($key);
    }

    /**
     * Get a configurations of launch app.
     * @param bool $null
     * @return array
     */
    public function application(bool $null = true) : array
    {
        $config = $this->appConfig;
        if ($null) {
            $this->appConfig = [];
        }
        return $config;
    }

    /**
     * Get storage interface.
     * @return Storage
     */
    public function getStorage() : Storage
    {
        if ($this->storage === null) {
            $this->storage = new Storage($this->getCache());
        }
        return $this->storage;
    }

    /**
     * Load a configuration of app.
     * @param  array $files
     * @return void
     */
    public function load(array $files) : void
    {
        $this->loadStorageConfig();
        $this->appConfig = $this->getCache()->getOrSet($this->env, function() use ($files){
            $config = $this->loadBaseConfig($files);
            return $this->loadInstalledComponentsConfig($config);
        });
    }

    /**
     * Update configuration by user.
     * @param $uid
     * @return void
     */
    public function updateComponentsByUser($uid) : void
    {
        $key    = self::COMPONENT . '.user.' . $uid;
        $config = $this->getCache()->getOrSet($key, function() use ($uid) {
            return $this->loadComponentsConfigByUser($uid);
        });
        $this->getStorage()->add(self::COMPONENT, $config);
        unset($config);
    }

    /**
     * Update configuration by user.
     * @param $did
     * @return void
     */
    public function updateComponentsByDomain($did) : void
    {
        $key    = self::COMPONENT . '.domain.' . $did;
        $config = $this->getCache()->getOrSet($key, function() use ($did) {
            return $this->loadComponentsConfigByDomain($did);
        });
        $this->getStorage()->add(self::COMPONENT, $config);
        unset($config);
    }

    /**
     * Load a base configuration.
     * @param array $files
     * @return array
     */
    protected function loadBaseConfig(array $files) : array
    {
        $config = [];
        foreach ($files as $file) {
            if (file_exists($file = Yii::getAlias($file))) {
                $config = ArrayHelper::merge($config, (array) require $file);
            }
        }
        return $config;
    }

    /**
     * Load storage configs.
     * @return void
     */
    protected function loadStorageConfig() : void
    {
        $this->getStorage()->existsOrSet('domain', function ($cache){
            try {
                return (new Query())->select('*')
                    ->from(Domain::tableName())
                    ->indexBy('domain')
                    ->all($this->getDb());
            } catch (\yii\db\Exception $exception) {
               return [];
            }
        });
        $this->getStorage()->existsOrSet('language', function ($cache){
            try {
                return (new Query())->select('*')
                    ->from(Language::tableName())
                    ->indexBy('slug')
                    ->all($this->getDb());
            } catch (\yii\db\Exception $exception) {
                return [];
            }
        });
        $this->getStorage()->existsOrSet('component', function ($cache){
            try {
                $config = [];
                $query  = (new Query())->select('*')
                    ->from(Setting::tableName())
                    ->where(['user_id' => null])
                    ->all($this->getDb());
                foreach ($query as $row) {
                    $config[$row['name']] = json_decode($row['json_value'], true);
                }
                return $config;
            } catch (\yii\db\Exception $exception) {
                return [];
            }
        });
    }

    /**
     * Load a configuration of installed components.
     * @param  array $config
     * @return array
     */
    protected function loadInstalledComponentsConfig(array $config = []) : array
    {
        $env    = $this->env === self::WEB ? 'web' : 'console';
        $config = FileHelper::loadExtensionsFiles('config/main.php',   $config);
        $config = FileHelper::loadExtensionsFiles("config/{$env}.php", $config);
        return $config;
    }

    /**
     * Load a configuration of modules bu user.
     * @param $uid
     * @return array
     */
    protected function loadComponentsConfigByUser($uid) : array
    {
        $config = [];
        $query  = (new Query())->select('*')
            ->from(Setting::tableName())
            ->where(['user_id' => $uid])
            ->all($this->getDb());
        foreach ($query as $row) {
            $config[$row['name']] = json_decode($row['json_value'], true);
        }
        return $config;
    }

    /**
     * Load a configuration of modules bu domain.
     * @param $did
     * @return array
     */
    protected function loadComponentsConfigByDomain($did) : array
    {
        $config = [];
        $query  = (new Query())->select('*')
            ->from(Setting::tableName())
            ->where(['did' => $did])
            ->all($this->getDb());
        foreach ($query as $row) {
            $config[$row['name']] = json_decode($row['json_value'], true);
        }
        return $config;
    }

    /**
     * Get a cache object.
     * @return object|FileCache
     */
    public function getCache() : FileCache
    {
        if (!$this->cache) {
            $this->cache = Yii::createObject([
                'class'     => FileCache::className(),
                'cachePath' => Yii::getAlias($this->cachePath)
            ]);
        }
        return $this->cache;
    }

    /**
     * Get a db object.
     * @return Connection
     * @throws InvalidConfigException
     */
    public function getDb() : Connection
    {
        $file = APP_DIR . '/config/db-local.php';
        if (!file_exists($file)) {
            throw new InvalidConfigException('Failed to instantiate component or class "db".');
        }
        $db = require $file;
        Yii::$container->setSingleton($db['class'], $db);
        return Yii::$container->get($db['class']);
    }
}