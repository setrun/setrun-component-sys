<?php

/**
 * @author Denis Utkin <dizirator@gmail.com>
 * @link   https://github.com/dizirator
 */

namespace setrun\sys\components\base;

use Yii;

/**
 * Theme represents an application theme.
 */
class Theme extends \yii\base\Theme
{
    /**
     * @var string
     */
    protected $assetUrl = null;

    /**
     * @var string
     */
    public $distDir = 'assets/dist';

    /**
     * @inheritdoc
     */
    public function applyTo($path)
    {
        $base = Yii::$app->getBasePath();
        $file = str_replace(['views/', $base], ['', $this->getBasePath()], $path);
        return !is_file($file) ? $path : $file;
    }

    /**
     * Get path to assets of theme.
     * @param bool $raw
     * @return array|string
     */
    public function getAssetUrl($raw = false)
    {
        if ($this->assetUrl === null) {
            $this->assetUrl = Yii::$app->assetManager->publish(
                $this->getBasePath() . '/' . $this->distDir
            );
        }
        return $raw ? $this->assetUrl : $this->assetUrl[1];
    }
}