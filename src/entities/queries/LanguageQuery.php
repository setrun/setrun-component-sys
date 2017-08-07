<?php

namespace setrun\sys\entities\queries;

/**
 * This is the ActiveQuery class for [[\setrun\sys\entities\Language]].
 *
 * @see Language
 */
class LanguageQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \setrun\sys\entities\Language[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \setrun\sys\entities\Language|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
