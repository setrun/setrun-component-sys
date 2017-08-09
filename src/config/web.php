<?php

/**
 * @author Denis Utkin <dizirator@gmail.com>
 * @link   https://github.com/dizirator
 */

return [
    'components' => [
        'urlManager' => [
            'class' => 'setrun\sys\components\web\UrlManager'
        ],
        'view' => [
            'theme' => [
                'class' => 'setrun\sys\components\base\Theme'
            ]
        ],
    ]
];