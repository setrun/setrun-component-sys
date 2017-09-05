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
    public const WEB      = 'application-web';
    public const CONSOLE  = 'application-console';

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
     * Get a settings of key.
     * @param null $key
     * @return Storage
     */
    public function setting($key = null) : Storage
    {
        $this->getStorage()->clearKey();
        $storage = $this->getStorage()->addKey(self::SETTING);
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
     * Get storage interface
     * @param bool $clone
     * @return Storage
     */
    public function getStorage($clone = false) : Storage
    {
        if ($this->storage === null) {
            $this->storage = new Storage($this->getCache());
        }
        return $clone ? clone $this->storage : $this->storage;
    }

    /**
     * Load a configuration of app.
     * @param  array $files
     * @return void
     */
    public function load(array $files) : void
    {
        $this->appConfig = $this->getCache()->getOrSet($this->env, function() use ($files){
            $config = $this->loadBaseConfig($files);
            return $this->loadInstalledComponentsConfig($config);
        });
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
}