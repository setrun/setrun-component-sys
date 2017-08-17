<?php

namespace setrun\sys\entities;

use Yii;
use setrun\sys\helpers\ArrayHelper;
use setrun\sys\entities\queries\LanguageQuery;

/**
 * This is the model class for table "{{%sys_language}}".
 *
 * @property integer $id
 * @property integer $domain_id
 * @property string  $slug
 * @property string  $name
 * @property string  $locale
 * @property string  $alias
 * @property string  $icon_id
 * @property integer $bydefault
 * @property integer $status
 * @property integer $position
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Domain $d
 */
class Language extends \yii\db\ActiveRecord
{
    public const STATUS_DRAFT  = 0;
    public const STATUS_ACTIVE = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sys_language}}';
    }

    /**
     * Create a new language.
     * @param $name
     * @param $slug
     * @param $locale
     * @param $alias
     * @param $icon_id
     * @param $status
     * @return Language
     */
    public static function create($name, $slug, $locale, $alias, $icon_id, $status) : self
    {
        $self = new static();
        $self->name    = $name;
        $self->slug    = $slug;
        $self->locale  = $locale;
        $self->alias   = $alias;
        $self->icon_id = $icon_id;
        $self->status  = $status;
        return $self;
    }

    /**
     * Edit a language.
     * @param $name
     * @param $slug
     * @param $locale
     * @param $alias
     * @param $icon_id
     * @param $status
     */
    public function edit($name, $slug, $locale, $alias, $icon_id, $status): void
    {
        $this->name    = $name;
        $this->slug    = $slug;
        $this->locale  = $locale;
        $this->alias   = $alias;
        $this->icon_id = $icon_id;
        $this->status  = $status;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return static::getAttributeLabels();
    }

    /**
     * @return array
     */
    public static function getAttributeLabels() : array
    {
        return [
            'id'         => Yii::t('setrun/sys/language', 'ID'),
            'domain_id'  => Yii::t('setrun/sys/language', 'Domain'),
            'slug'       => Yii::t('setrun/sys/language', 'Slug'),
            'name'       => Yii::t('setrun/sys/language', 'Name'),
            'locale'     => Yii::t('setrun/sys/language', 'Locale'),
            'alias'      => Yii::t('setrun/sys/language', 'Alias'),
            'icon_id'    => Yii::t('setrun/sys/language', 'Icon'),
            'bydefault'  => Yii::t('setrun/sys/language', 'Default'),
            'status'     => Yii::t('setrun/sys/language', 'Status'),
            'position'   => Yii::t('setrun/sys/language', 'Position'),
            'created_at' => Yii::t('setrun/sys/language', 'Created At'),
            'updated_at' => Yii::t('setrun/sys/language', 'Updated At'),
        ];
    }

    /**
     * Get all statuses.
     * @return array
     */
    public static function getStatuses() : array
    {
        return [
            self::STATUS_ACTIVE => Yii::t('setrun/sys/language', 'Active'),
            self::STATUS_DRAFT  => Yii::t('setrun/sys/language', 'Draft')
        ];
    }

    /**
     * Get the status of the name.
     * @return string
     */
    public function getStatusName() : string
    {
        return ArrayHelper::get(self::getStatuses(), $this->status);
    }
}
