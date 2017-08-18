<?php

/**
 * @author Denis Utkin <dizirator@gmail.com>
 * @link   https://github.com/dizirator
 */

namespace setrun\sys\assets;

use setrun\sys\components\web\AssetBundle;

/**
 * Class NotyAsset.
 * @link https://github.com/needim/noty
 */
class NotyAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@vendor/needim/noty/lib';

    /**
     * @inheritdoc
     */
    public $js = [
        'noty.min.js'
    ];

    /**
     * @inheritdoc
     */
    public $css = [
        'noty.css'
    ];

    public $publishOptions = [
        'only' => [
            'noty.min.js',
            'noty.min.js.map',
            'noty.css'
        ],
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\JqueryAsset'
    ];
}
