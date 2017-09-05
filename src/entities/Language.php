<?php

namespace setrun\sys\entities;

use Yii;
use setrun\sys\helpers\ArrayHelper;
use setrun\sys\helpers\LanguageHelper;

/**
 * This is the model class for table "{{%sys_language}}".
 * @property integer $id
 * @property string  $slug
 * @property string  $name
 * @property string  $locale
 * @property string  $alias
 * @property string  $icon
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 */
class Language extends \yii\db\ActiveRecord
{
    public const STATUS_DRAFT  = 0;
    public const STATUS_ACTIVE = 1;

    /**
     * @inheritdoc
     */
    public static function tableName() : string
    {
        return '{{%sys_language}}';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() : array
    {
        return LanguageHelper::getAttributeLabels();
    }

    /**
     * Create a new language.
     * @param  string $name
     * @param  string $slug
     * @param  string $locale
     * @param  string $alias
     * @param  string $icon
     * @return self
     */
    public static function create($name, $slug, $locale, $alias, $icon) : self
    {
        $self = new static();
        $self->name    = $name;
        $self->slug    = $slug;
        $self->locale  = $locale;
        $self->alias   = $alias;
        $self->icon    = $icon;
        $self->created_by = Yii::$app->user->identity->id;
        $self->updated_by = Yii::$app->user->identity->id;
        return $self;
    }

    /**
     * Edit a language.
     * @param string $name
     * @param string $slug
     * @param string $locale
     * @param string $alias
     * @param string $icon
     * @return void
     */
    public function edit($name, $slug, $locale, $alias, $icon): void
    {
        $this->name   = $name;
        $this->slug   = $slug;
        $this->locale = $locale;
        $this->alias  = $alias;
        $this->icon   = $icon;
        $this->updated_by = Yii::$app->user->identity->id;
    }

    /**
     * Get the status of the name.
     * @return string
     */
    public function getStatusName() : string
    {
        return ArrayHelper::get(LanguageHelper::getStatuses(), $this->status);
    }

    /**
     * Get list of languages.
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getList()
    {
        return self::find()
        ->select(['id', 'slug', 'name','locale', 'alias', 'icon'])
        ->indexBy('slug')
        ->asArray()
        ->all();
    }
}
