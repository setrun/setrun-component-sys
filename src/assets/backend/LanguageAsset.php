<?php

/**
 * @author Denis Utkin <dizirator@gmail.com>
 * @link   https://github.com/dizirator
 */

namespace setrun\sys\assets\backend;

use setrun\sys\over\web\AssetBundle;

/**
 * Class LanguageAsset.
 */
class LanguageAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@setrun/sys/assets/backend/dist';

    /**
     * @inheritdoc
     */
    public $depends = [
        'theme\assets\ThemeAsset'
    ];
}