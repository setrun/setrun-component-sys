<?php

/**
 * @author Denis Utkin <dizirator@gmail.com>
 * @link   https://github.com/dizirator
 */

namespace setrun\sys\helpers;

use Yii;
use yii\base\Model;
use yii\helpers\Html;

/**
 * Error helper.
 */
class ErrorHelper
{
    /**
     * Check input errors.
     * @param  array $errors
     * @param  Model $model
     * @return array
     */
    public static function checkModel($errors, Model $model) : array
    {
        $output = [];
        if (!is_array($errors)) {
            return $output;
        }
        foreach ($errors as $attribute => $message) {
            $obj = $model;
            if (strpos($attribute, '.') !== false) {
                list($nested, $attr) = explode('.', $attribute);
                if (isset($obj->{$nested}) && $obj->{$nested} instanceof Model) {
                    $obj       = $obj->{$nested};
                    $attribute = $attr;
                }
            }
            if ($obj->hasProperty($attribute)) {
                $output[Html::getInputId($obj, $attribute)] = $message;
            } else {
                $output[] = $message;
            }
        }
        return $output;
    }
}