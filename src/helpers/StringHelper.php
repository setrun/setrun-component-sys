<?php

/**
 * @author Denis Utkin <dizirator@gmail.com>
 * @link   https://github.com/dizirator
 */

namespace setrun\sys\helpers;

/**
 * String helper.
 */
class StringHelper extends \yii\helpers\StringHelper
{
    /**
     * Add's _1 to a string or increment the ending number to allow _2, _3, etc.
     * @param   string  $str        required
     * @param   int     $first      number that is used to mean first
     * @param   string  $separator  separtor between the name and the number
     * @return  string
     */
    public static function increment($str, $first = 1, $separator = '_') : string
    {
        preg_match('/(.+)'.$separator.'([0-9]+)$/', $str, $match);
        return isset($match[2]) ? $match[1].$separator.($match[2] + 1) : $str.$separator.$first;
    }

    /**
     * Declination of words.
     * @param $number
     * @param $suffix
     * @return mixed
     */
    static public function declination($number, $suffix)
    {
        $keys = array(2, 0, 1, 1, 1, 2);
        $mod = $number % 100;
        $suffix_key = ($mod > 7 && $mod < 20) ? 2: $keys[min($mod % 10, 5)];
        return $suffix[$suffix_key];
    }
}