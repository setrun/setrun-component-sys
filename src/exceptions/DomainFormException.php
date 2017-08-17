<?php

/**
 * @author Denis Utkin <dizirator@gmail.com>
 * @link   https://github.com/dizirator
 */

namespace setrun\sys\exceptions;

use Throwable;
use yii\base\Model;

/**
 * Class DomainFormException.
 */
class DomainFormException extends \DomainException
{
    /**
     * @var array
     */
    public $data = [];

    /**
     * DomainFormException constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
        parent::__construct('', 0, null);
    }

    /**
     * @param Model $form
     */
    public function prepareForm(Model &$form)
    {
        foreach ($this->data as $key => $value) {
            if ($form->hasProperty($key)) {
                $form->addError($key, $value);
            }
        }
    }
}