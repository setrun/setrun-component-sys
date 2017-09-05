<?php

/**
 * @author Denis Utkin <dizirator@gmail.com>
 * @link   https://github.com/dizirator
 */

use yii\helpers\Url;

return [
    'sys' => [
        'label' => Yii::t('setrun/sys', 'System'),
        'icon'  => 'sliders',
        'url'   => '#',
        'items' => [
            [
                'label'      => Yii::t('setrun/sys/domain', 'Domains'),
                'url'        => ['/sys/backend/domain/index'],
                'controller' => 'backend/domain'
            ],
            [
                'label'      => Yii::t('setrun/sys/language', 'Languages'),
                'url'        => ['/sys/backend/language/index'],
                'controller' => 'backend/language'
            ],
            [
                'label'      => Yii::t('setrun/sys/setting', 'Settings'),
                'url'        => ['/sys/backend/setting/index'],
                'controller' => 'backend/setting'
            ],
            [
                'label'      => Yii::t('setrun/sys/component', 'Components'),
                'url'        => ['/sys/backend/component/index'],
                'controller' => 'backend/component'
            ]

        ]
    ]
];
