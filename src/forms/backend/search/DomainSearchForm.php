<?php

/**
 * @author Denis Utkin <dizirator@gmail.com>
 * @link   https://github.com/dizirator
 */

namespace setrun\sys\forms\backend\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use setrun\sys\entities\manage\Domain;
use setrun\sys\behaviors\TimeAgoBehavior;

/**
 * DomainSearch represents the model behind the search form about `setrun\sys\entities\Domain`.
 */
class DomainSearchForm extends Model
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
    public function search($params)
    {
        $query = Domain::find();

        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }

        if (!is_null($this->updated_at) && strpos($this->updated_at, ' - ') !== false ) {
            list($start_date, $end_date) = explode(' - ', $this->updated_at);
            $query->andFilterWhere(['>=', 'updated_at', (int)strtotime($start_date)]);
            $query->andFilterWhere(['<=', 'updated_at', (int)strtotime($end_date) + 24 * 3600]);
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'name',  $this->name])
              ->andFilterWhere(['like', 'url',   $this->url]);

        return $dataProvider;
    }

    public function formName()
    {
        return 'search';
    }
}
