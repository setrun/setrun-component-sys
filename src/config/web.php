<?php

/**
 * @author Denis Utkin <dizirator@gmail.com>
 * @link   https://github.com/dizirator
 */

return [
    'components' => [
        'urlManager' => [
            'class' => 'setrun\sys\over\web\UrlManager'
        ],
        'view' => [
            'theme' => [
                'class' => 'setrun\sys\over\base\Theme'
            ]
        ],
    ]
];