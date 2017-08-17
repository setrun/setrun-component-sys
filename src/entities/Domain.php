<?php

/**
 * @author Denis Utkin <dizirator@gmail.com>
 * @link   https://github.com/dizirator
 */

namespace setrun\sys\entities;

use Yii;

/**
 * This is the model class for table "{{%sys_domain}}".
 * @property integer    $id
 * @property string     $name
 * @property string     $alias
 * @property string     $url
 * @property integer    $created_at
 * @property integer    $updated_at
 * @property integer    $created_by
 * @property integer    $updated_by
 * @property Setting[]  $settings
 * @property Language[] $languages
 */
class Domain extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sys_domain}}';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return static::getAttributeLabels();
    }

    /**
     * Create domain.
     * @param $name
     * @param $alias
     * @param $url
     * @return Domain
     */
    public static function create($name, $alias, $url) : self
    {
        $self = new static();
        $self->name  = $name;
        $self->alias = $alias;
        $self->url   = $url;
        $self->created_by = Yii::$app->user->identity->id;
        $self->updated_by = Yii::$app->user->identity->id;
        return $self;
    }

    /**
     * @return array
     */
    public static function getAttributeLabels() : array
    {
        return [
            'id'         => Yii::t('setrun/sys/domain', 'ID'),
            'name'       => Yii::t('setrun/sys/domain', 'Name'),
            'alias'      => Yii::t('setrun/sys/domain', 'Alias'),
            'url'        => Yii::t('setrun/sys/domain', 'Url'),
            'created_at' => Yii::t('setrun/sys/domain', 'Created At'),
            'updated_at' => Yii::t('setrun/sys/domain', 'Updated At'),
            'created_by' => Yii::t('setrun/sys/domain', 'Created By'),
            'updated_by' => Yii::t('setrun/sys/domain', 'Updated By'),
        ];
    }

    /**
     * Update domain.
     * @param $name
     * @param $domain
     * @return void
     */
    public function edit($name, $alias, $url): void
    {
        $this->name  = $name;
        $this->alias = $alias;
        $this->url   = $url;
        $this->updated_by = Yii::$app->user->identity->id;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSettings()
    {
        return $this->hasMany(Setting::className(), ['domain_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguages()
    {
        return $this->hasMany(Language::className(), ['domain_id' => 'id']);
    }
}
