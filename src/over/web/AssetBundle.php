<?php

/**
 * @author Denis Utkin <dizirator@gmail.com>
 * @link   https://github.com/dizirator
 */

namespace setrun\sys\over\web;

use Yii;
use setrun\sys\helpers\FileHelper;

/**
 * AssetBundle represents a collection of asset files, such as CSS, JS, images.
 */
class AssetBundle extends \yii\web\AssetBundle
{
    /**
     * @var null
     */
    protected static $assetUrl = null;

    /**
     * @inheritdoc
     */
    public static function register($view, array $files = []) : \yii\web\AssetBundle
    {
        $bundle =  parent::register($view);
        if (!empty($files)) {
            foreach ($files as $file) {
                if (strpos($file, '.css') !== false) {
                    $view->registerCssFile($bundle->baseUrl . '/' . $file, ['depends' => static::className()]);
                } elseif (strpos($file, '.js') !== false) {
                    $view->registerJsFile($bundle->baseUrl  . '/' . $file, ['depends' => static::className()]);
                }
            }
        }
        return $bundle;
    }

    /**
     * Get a asset url of bundle.
     * @param string $path
     * @return string
     */
    public static function getAssetUrl(string $path = '') : string
    {
        if (static::$assetUrl === null) {
            static::$assetUrl = FileHelper::getAssetUrl(static::className());
        }
        ;
        return static::$assetUrl . $path;
    }
}