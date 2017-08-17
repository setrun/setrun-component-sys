<?php

/**
 * @author Denis Utkin <dizirator@gmail.com>
 * @link   https://github.com/dizirator
 */

namespace setrun\sys\forms\backend;

use Yii;
use yii\base\Model;
use setrun\sys\entities\manage\Domain;

/**
 * Class DomainForm.
 */
class DomainForm extends Model
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
    public $alias;

    /**
     * @var string
     */
    public $url;

    public function __construct(Domain $model = null, $config = [])
    {
        if ($model) {
            $this->id    = $model->id;
            $this->name  = $model->name;
            $this->alias = $model->alias;
            $this->url   = $model->url;
        }
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'url', 'alias'], 'required'],
            [['url'], 'url'],
            [['name', 'url', 'alias'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
       return Domain::getAttributeLabels();
    }
}