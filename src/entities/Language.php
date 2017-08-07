<?php

namespace setrun\sys\entities;

use Yii;
use setrun\sys\entities\queries\LanguageQuery;

/**
 * This is the model class for table "{{%sys_language}}".
 *
 * @property integer $id
 * @property integer $did
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
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sys_language}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['did', 'bydefault', 'status', 'position', 'created_at', 'updated_at'], 'integer'],
            [['slug', 'name', 'locale', 'alias', 'created_at', 'updated_at'], 'required'],
            [['slug', 'name', 'alias'], 'string', 'max' => 50],
            [['locale'], 'string', 'max' => 255],
            [['icon_id'], 'string', 'max' => 10],
            [['did'], 'exist', 'skipOnError' => true, 'targetClass' => Domain::className(), 'targetAttribute' => ['did' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'         => Yii::t('setrun\sys\language', 'ID'),
            'did'        => Yii::t('setrun\sys\language', 'Did'),
            'slug'       => Yii::t('setrun\sys\language', 'Slug'),
            'name'       => Yii::t('setrun\sys\language', 'Name'),
            'locale'     => Yii::t('setrun\sys\language', 'Locale'),
            'alias'      => Yii::t('setrun\sys\language', 'Alias'),
            'icon_id'    => Yii::t('setrun\sys\language', 'Icon ID'),
            'by_default' => Yii::t('setrun\sys\language', 'Default'),
            'status'     => Yii::t('setrun\sys\language', 'Status'),
            'position'   => Yii::t('setrun\sys\language', 'Position'),
            'created_at' => Yii::t('setrun\sys\language', 'Created At'),
            'updated_at' => Yii::t('setrun\sys\language', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getD()
    {
        return $this->hasOne(Domain::className(), ['id' => 'did']);
    }

    /**
     * @inheritdoc
     * @return LanguageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new LanguageQuery(get_called_class());
    }
}
