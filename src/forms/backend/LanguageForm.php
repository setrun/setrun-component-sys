<?php

/**
 * @author Denis Utkin <dizirator@gmail.com>
 * @link   https://github.com/dizirator
 */

namespace setrun\sys\forms\backend;

use Yii;
use yii\base\Model;
use setrun\sys\entities\manage\Language;

/**
 * Class LanguageForm.
 */
class LanguageForm extends Model
{
    /**
     * @var mixed
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $slug;

    /**
     * @var string
     */
    public $locale;

    /**
     * @var string
     */
    public $alias;

    /**
     * @var string
     */
    public $icon_id;

    /**
     * @var string
     */
    public $status;

    /**
     * LanguageForm constructor.
     * @param Language|null $model
     * @param array $config
     */
    public function __construct(Language $model = null, $config = [])
    {
        if ($model) {
            $this->id      = $model->id;
            $this->name    = $model->name;
            $this->alias   = $model->alias;
            $this->slug    = $model->slug;
            $this->icon_id = $model->icon_id;
            $this->locale  = $model->locale;
            $this->status  = $model->status;
        } else {
            $this->status = Language::STATUS_ACTIVE;
        }
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'slug', 'alias'], 'required'],
            [['status'], 'integer'],
            [['slug', 'name', 'alias'], 'string', 'max' => 50],
            [['locale'],  'string', 'max' => 255],
            [['icon_id'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return Language::getAttributeLabels();
    }
}