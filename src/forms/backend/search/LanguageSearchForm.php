<?php

/**
 * @author Denis Utkin <dizirator@gmail.com>
 * @link   https://github.com/dizirator
 */

namespace setrun\sys\forms\backend\search;

use Yii;
use setrun\sys\components\base\SearchForm;

/**
 * LanguageSearchForm represents the model behind the search form about `setrun\sys\entities\manage\Language`.
 */
class LanguageSearchForm extends SearchForm
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
    public $slug;

    /**
     * @var string
     */
    public $updated_at;

    /**
     * @inheritdoc
     */
    protected $modelClass = 'setrun\sys\entities\manage\Language';

    /**
     * @inheritdoc
     */
    protected $defaultOrder = ['slug' => SORT_ASC];

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'slug', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function buildFilter(&$query)
    {
        $this->filterTimestamp($query);

        $query->andFilterWhere([
            'id' => $this->id
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['like', 'slug', $this->slug]);
    }
}
