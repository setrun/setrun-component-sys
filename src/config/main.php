<?php

/**
 * @author Denis Utkin <dizirator@gmail.com>
 * @link   https://github.com/dizirator
 */

return [
    'bootstrap' => ['queue'],
    'components' => [
        'queue' => [
            'class'  => \yii\queue\db\Queue::class,
            'mutex'  => \yii\mutex\MysqlMutex::class,
            'as log' => \yii\queue\LogBehavior::class
        ],
        'config' => [
            'class' => 'setrun\sys\components\Configurator'
        ],
        'i18n' => [
            'translations' => [
                'setrun/sys*' => [
                    'class'    => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@setrun/sys/messages',
                    'fileMap' => [
                        'setrun/sys' => 'sys.php',

                    ]
                ]
            ]
        ],
    ],
    'modules' => [
        'sys' => 'setrun\sys\Module'
    ]
];