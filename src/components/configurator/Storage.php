<?php

/**
 * @author Denis Utkin <dizirator@gmail.com>
 * @link   https://github.com/dizirator
 */

namespace setrun\sys\components\configurator;

use yii\db\Connection;
use yii\caching\FileCache;
use setrun\sys\helpers\ArrayHelper;

/**
 * Class Storage.
 */
class Storage
{
    protected const KEY = 'application.storage';

    /**
     * @var FileCache
     */
    protected $cache;

    /**
     * @var array
     */
    protected $keys = [];

    /**
     * @var array
     */
    protected $storage = [];

    /**
     * Storage constructor.
     * @param FileCache $cache
     */
    public function __construct(FileCache $cache)
    {
        $this->cache = $cache;
        if(!($this->storage = $this->cache->get(self::KEY))){
            $this->storage = [];
        }

    }

    /**
     * Get array value.
     * @param null $key
     * @param null $default
     * @return array|mixed
     */
    public function get($key = '', $default = null)
    {
        $key = $this->getCompositeKey($key);
        if (empty($key)) {
            return $this->storage;
        }
        return ArrayHelper::getValue($this->storage, $key, $default);
    }

    /**
     * Set array value.
     * @param $key
     * @param null $value
     * @return void
     */
    public function set($key, $value = null) : void
    {
        if (is_array($key)) {
            $this->storage  = array_replace_recursive($this->storage, $key);
        } elseif ($value !== null) {
            $key = $this->getCompositeKey($key);
            ArrayHelper::set($this->storage, $key, $value);
        }
        $this->cache->set(self::KEY, $this->storage);
    }

    /**
     * Add array value.
     * @param $key
     * @param null $value
     * @return void
     */
    public function add($key, $value = null) : void
    {
        if (is_array($key)) {
            $this->storage  = array_replace_recursive($this->storage, $key);
        } elseif ($value !== null) {
            $key = $this->getCompositeKey($key);
            ArrayHelper::set($this->storage, $key, $value);
        }
    }

    /**
     * Delete array value.
     * @param $key
     * @return void
     */
    public  function delete($key) : void
    {
        $key = $this->getCompositeKey($key);
        ArrayHelper::delete($this->storage, $key);
        $this->cache->set(self::KEY, $this->storage);
    }

    /**
     * Get or ser array value.
     * @param $key
     * @param \Closure $fn
     * @return array|mixed
     */
    public function getOrSet($key, \Closure $fn)
    {
        $key = $this->getCompositeKey($key);
        if (($value = $this->get($key)) !== null) {
            return $value;
        }
        if ($fn instanceof \Closure) {
            $value = $fn($this);
            $this->set($key, $value);
        }
    }

    /**
     * Get and delete array value.
     * @param $key
     * @return array|mixed
     */
    public function getAndDelete($key)
    {
        $key   = $this->getCompositeKey($key);
        $value = $this->get($key);
        $this->delete($key);
        return $value;
    }

    /**
     * Key exists or ser array value.
     * @param $key
     * @param \Closure $fn
     * @return bool
     */
    public function existsOrSet($key, \Closure $fn) : bool
    {
        $key = $this->getCompositeKey($key);
        if (!ArrayHelper::key_exists($this->storage, $key)) {
            if ($fn instanceof \Closure) {
                $value = $fn($this);
                $this->set($key, $value);
            }
            return false;
        }
        return true;
    }

    /**
     * @param string $key
     * @return Storage
     */
    public function addKey(string $key) : self
    {
        if (!in_array($key, $this->keys)) {
            $this->keys[] = $key;
        }
        return $this;
    }

    /**
     * @return void
     */
    public function clearKey() : void
    {
        $this->keys = [];
    }

    /**
     * Get a composite key.
     * @param  string $key
     * @return string
     */
    protected function getCompositeKey(string $key) : string
    {
        $keys = $this->keys;
        $keys[] = $key;
        $output = implode('.', $keys);
        return trim($output, '.');
    }
}