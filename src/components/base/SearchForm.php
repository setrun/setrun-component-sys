<?php

/**
 * @author Denis Utkin <dizirator@gmail.com>
 * @link   https://github.com/dizirator
 */

namespace setrun\sys\components\base;

use Yii;
use yii\db\ActiveRecord;
use yii\data\ActiveDataProvider;
use setrun\sys\helpers\ArrayHelper;
use yii\base\InvalidConfigException;

/**
 * Class SearchForm.
 */
abstract class SearchForm extends Form
{
    /**
     * @var string
     */
    protected $modelClass;

    /**
     * @var string
     */
    protected $method = 'get';

    /**
     * @var mixed
     */
    protected $defaultOrder;

    /**
     * @var \yii\db\ActiveRecord
     */
    protected $model;

    /**
     * @inheritdoc
     */
    public function __construct(array $attributes = [], array $config = [])
    {
        if (!isset($this->modelClass) && !isset($config['modelClass'])) {
            throw new InvalidConfigException('Active record model class is not defined');
        }
        $this->model = Yii::createObject(['class' => $this->modelClass]);
        parent::__construct($attributes, $config);
    }

    /**
     * @inheritdoc
     */
    public function formName()
    {
        return 'search';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return $this->model->attributeLabels();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return $this->model->rules();
    }


    /**
     * Creates data provider instance with search query applied
     * @return ActiveDataProvider
     */
    public function search() : ActiveDataProvider
    {
        return $this->createDataProvider();
    }

    /**
     * Get a model class.
     * @return string
     */
    public function getModelClass() : string
    {
        return $this->modelClass;
    }

    /**
     * Set a model class.
     * @param string $modelClass
     * @return void
     */
    public function setModelClass(string $modelClass) : void
    {
        $this->modelClass = $modelClass;
    }

    /**
     * Get a request method.
     * @return string
     */
    public function getMethod() : string
    {
        return $this->method;
    }

    /**
     * Set a request method.
     * @param string $method
     */
    public function setMethod($method) : void
    {
        $this->method = $method;
    }

    /**
     * Get a default sorting order.
     * @return mixed
     */
    public function getDefaultOrder()
    {
        return $this->defaultOrder;
    }

    /**
     * Set a default sorting order.
     * @param mixed $defaultOrder
     */
    public function setDefaultOrder($defaultOrder) : void
    {
        $this->defaultOrder = $defaultOrder;
    }

    /**
     * Get a model.
     * @return ActiveRecord
     */
    public function getModel() : ActiveRecord
    {
        return $this->model;
    }

    /**
     * Set a model.
     * @param ActiveRecord $model
     */
    public function setModel(ActiveRecord $model) : void
    {
        $this->model = $model;
    }

    /**
     * Create ActiveDataProvider.
     * @return \yii\data\ActiveDataProvider
     */
    protected function createDataProvider() : ActiveDataProvider
    {
        $query = $this->buildQuery();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'  => [
                'defaultOrder' => $this->defaultOrder
            ]
        ]);

        if (!$this->load($this->requestData())) {
            return $dataProvider;
        }
        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }
        $this->buildFilter($query);

        return $dataProvider;
    }

    /**
     * Build sql query.
     * @return \yii\db\ActiveQuery
     */
    protected function buildQuery()
    {
        /* @var $query \yii\db\ActiveQuery */
        $query = call_user_func([$this->model, 'find']);
        return $query;
    }

    /**
     * Should be implemented in descendand classes
     * @param \yii\db\QueryInterface $query
     */
    protected function buildFilter(&$query)
    {
    }

    /**
     * Get request data params.
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    protected function requestData() : array
    {
        switch ($this->method) {
            case 'post':
                return Yii::$app->request->post();
            case 'get':
                return Yii::$app->request->getQueryParams();
            default:
                throw new InvalidConfigException('Request method is not defined');
        }
    }

    /**
     * Add filter on timestamp.
     * @param string $attr
     */
    protected function filterTimestamp(&$query, $attr = 'updated_at')
    {
        if (!is_null($this->{$attr}) && strpos($this->{$attr}, ' - ') !== false ) {
            list($start_date, $end_date) = explode(' - ', $this->{$attr});
            $query->andFilterWhere(['>=', $attr, (int)strtotime($start_date)]);
            $query->andFilterWhere(['<=', $attr, (int)strtotime($end_date) + 24 * 3600]);
        }
    }
}