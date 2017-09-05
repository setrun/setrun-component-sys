<?php

/**
 * @author Denis Utkin <dizirator@gmail.com>
 * @link   https://github.com/dizirator
 */

namespace setrun\sys\forms\backend;

use Yii;
use setrun\sys\components\base\Form;
use setrun\sys\helpers\LanguageHelper;
use setrun\sys\entities\manage\Language;

/**
 * Class LanguageForm.
 */
class LanguageForm extends Form
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
    public $icon;

    /**
     * @var Language
     */
    private $_model;

    /**
     * LanguageForm constructor.
     * @param Language|null $model
     * @param array $config
     */
    public function __construct(Language $model = null, $config = [])
    {
        if ($model) {
            $this->id     = $model->id;
            $this->name   = $model->name;
            $this->alias  = $model->alias;
            $this->slug   = $model->slug;
            $this->icon   = $model->icon;
            $this->locale = $model->locale;
        }
        $this->_model = $model;
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'slug', 'alias'], 'required'],
            [['slug', 'name', 'alias', 'locale'], 'string', 'max' => 50],
            [['icon'], 'string', 'max' => 10]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return LanguageHelper::getAttributeLabels();
    }
}