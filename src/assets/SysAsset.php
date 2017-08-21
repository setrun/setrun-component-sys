<?php

/**
 * @author Denis Utkin <dizirator@gmail.com>
 * @link   https://github.com/dizirator
 */

namespace setrun\sys\assets;

use setrun\sys\over\web\AssetBundle;

/**
 * Class SysAsset.
 */
class SysAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@setrun/sys/assets/dist';

    /**
     * @inheritdoc
     */
    public $js = [
        'js/setrun.js'
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\JqueryAsset'
    ];
}