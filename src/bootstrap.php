<?php

/**
 * @author Denis Utkin <dizirator@gmail.com>
 * @link   https://github.com/dizirator
 */

use setrun\sys\interfaces\i18nInterface;
use setrun\sys\services\i18nService;

\Yii::$container->setSingleton(i18nInterface::class, i18nService::class);