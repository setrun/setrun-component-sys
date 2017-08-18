<?php

/**
 * @author Denis Utkin <dizirator@gmail.com>
 * @link   https://github.com/dizirator
 */

namespace setrun\sys\forms\backend\search;

use Yii;
use setrun\sys\components\base\SearchForm;

/**
 * DomainSearch represents the model behind the search form about `setrun\sys\entities\Domain`.
 */
class DomainSearchForm extends SearchForm
{
    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $url;

    /**
     * @var string
     */
    public $updated_at;

    /**
     * @var string
     */
    protected $modelClass = 'setrun\sys\entities\manage\Domain';

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'url', 'updated_at',], 'safe'],
        ];
    }

    /**
     * Creates data provider instance with search query applied
     * @param array $params
     * @return ActiveDataProvider
     */
    public function buildFilter(&$query)
    {
        $this->filterTimestamp($query, 'updated_at');

        $query->andFilterWhere([
            'id' => $this->id,
        ]);
        $query->andFilterWhere(['like', 'name',  $this->name])
              ->andFilterWhere(['like', 'url',   $this->url]);
    }
}
