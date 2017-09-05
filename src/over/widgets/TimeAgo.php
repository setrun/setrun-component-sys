<?php

/**
 * @author Denis Utkin <dizirator@gmail.com>
 * @link   https://github.com/dizirator
 */

namespace setrun\sys\over\widgets;

use Yii;
use yii\base\InvalidConfigException;

/**
 * Over class \yii\timeago\TimeAgo.
 */
class TimeAgo extends \yii\timeago\TimeAgo
{
    /**
     * Registred locale js file.
     */
    protected function registerLocale()
    {
        $lang = $this->prepareLang();
        if (file_exists(Yii::getAlias($this->getAssetBundle()->sourcePath) . DIRECTORY_SEPARATOR . "locales" . DIRECTORY_SEPARATOR . "jquery.timeago.{$lang}.js")) {
            $this->getAssetBundle()->js[] = "locales/jquery.timeago.{$lang}.js";
        } else {
            throw new InvalidConfigException("Language '{$lang}' do not exist.");
        }
    }

    /**
     * Prepare name of language.
     * @return string
     */
    protected function prepareLang()
    {
        $lang = $this->language;
        if (strpos($lang, '-') !== false) {
            $lang = strtolower(explode('-', $lang)[0]);
        }
        return $lang;
    }
}