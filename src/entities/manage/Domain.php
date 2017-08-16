<?php

/**
 * @author Denis Utkin <dizirator@gmail.com>
 * @link   https://github.com/dizirator
 */

namespace setrun\sys\entities\manage;

use Yii;
use setrun\sys\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;
use setrun\sys\behaviors\TimeAgoBehavior;

/**
 * Class Domain.
 */
class Domain extends \setrun\sys\entities\Domain
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return ArrayHelper::merge([
            'timeAgo'   => TimeAgoBehavior::class,
            'timestamp' => TimestampBehavior::class,
        ], parent::behaviors());
    }
}
