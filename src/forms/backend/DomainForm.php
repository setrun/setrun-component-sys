<?php

/**
 * @author Denis Utkin <dizirator@gmail.com>
 * @link   https://github.com/dizirator
 */

namespace setrun\sys\forms\backend;

use Yii;
use yii\base\Model;
use setrun\sys\entities\Domain;

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

    public function __construct(Domain $domain = null, $config = [])
    {
        if ($domain) {
            $this->id    = $domain->id;
            $this->name  = $domain->name;
            $this->alias = $domain->alias;
            $this->url   = $domain->url;

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
        return [
            'id'    => 'ID',
            'name'  => Yii::t('setrun/sys/domain', 'Name'),
            'alias' => Yii::t('setrun/sys/domain', 'Alias'),
            'url'   => Yii::t('setrun/sys/domain', 'Url')
        ];
    }
}