<?php

/**
 * @author Denis Utkin <dizirator@gmail.com>
 * @link   https://github.com/dizirator
 */

namespace setrun\sys\behaviors;

use Yii;
use yii\helpers\Html;
use yii\base\Behavior;
use setrun\sys\over\widgets\TimeAgo;

/**
 * Format to the desired date format with jquery plugin
 */
class TimeAgoBehavior extends Behavior
{
    /**
     * Name of attribute which holds the attachment.
     * @var string
     */
    public $attribute  = 'updated_at';

    /**
     * Get a date in the time ago format
     * @return string
     * @throws \Exception
     */
    public function getTimeAgo($field = null, $options = []){
        $attribute = $this->attribute;
        if ($field !== null) {
            $attribute = $field;
        }

        $year  = $options['year'] ??  'full:{day} {month} {year}';
        $month = $options['month'] ?? 'full:{day} {month}';

        if ($this->owner->hasAttribute($attribute)) {
            $value = $this->owner{$attribute};
            if (!is_numeric($this->owner{$attribute})) {
                $value = strtotime($this->owner{$attribute});
            }
            $updatedM  = date('m', $value);
            $currM     = date('m', time());
            $updatedY  = date('Y', $value);
            $currY     = date('Y', time());

            if ($updatedY !== $currY) {
                return Html::tag('time', Yii::$app->formatter->asDate($value, 'long'));
            }
            if ($updatedM < $currM) {
                return Html::tag('time', Yii::$app->formatter->asDate($value, 'medium'));
            }
            return TimeAgo::widget(['timestamp' => $value, 'language' => Yii::$app->language]);
        }
        return null;
    }
}