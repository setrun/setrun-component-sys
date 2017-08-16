<?php

namespace setrun\sys\forms\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use setrun\sys\entities\Language;

/**
 * LanguageSearch represents the model behind the search form about `setrun\sys\entities\Language`.
 */
class LanguageSearch extends Language
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'domain_id', 'bydefault', 'status', 'position', 'created_at', 'updated_at'], 'integer'],
            [['slug', 'name', 'locale', 'alias', 'icon_id'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Language::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'domain_id' => $this->domain_id,
            'bydefault' => $this->bydefault,
            'status' => $this->status,
            'position' => $this->position,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'locale', $this->locale])
            ->andFilterWhere(['like', 'alias', $this->alias])
            ->andFilterWhere(['like', 'icon_id', $this->icon_id]);

        return $dataProvider;
    }
}
