<?php

/**
 * @author Denis Utkin <dizirator@gmail.com>
 * @link   https://github.com/dizirator
 */

use yii\helpers\Url;

return [
    'a-sys' => [
        'label' => Yii::t('setrun/sys', 'System'),
        'icon'  => 'sliders',
        'url'   => '#',
        'items' => [
            [
                'label'      => Yii::t('setrun/sys/doamin', 'Domains'),
                'url'        => ['/sys/backend/domain/index'],
                //'icon'       => 'server',
                'controller' => 'backend/domain'
            ],
            [
                'label'      => Yii::t('setrun/sys/language', 'Languages'),
                'url'        => ['/sys/backend/language/index'],
                //'icon'       => 'language',
                'controller' => 'backend/language'
            ],
            [
                'label'      => Yii::t('setrun/sys/setting', 'Settings'),
                'url'        => ['/sys/backend/setting/index'],
                //'icon'       => 'cog',
                'controller' => 'backend/setting'
            ],
            [
                'label'      => Yii::t('setrun/sys/component', 'Components'),
                'url'        => ['/sys/backend/component/index'],
                //'icon'       => 'plug',
                'controller' => 'backend/component'
            ]

        ]
    ]
];
