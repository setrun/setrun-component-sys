<?php

/**
 * @author Denis Utkin <dizirator@gmail.com>
 * @link   https://github.com/dizirator
 */

namespace setrun\sys\exceptions;

use yii\base\Model;

/**
 * Class YiiException.
 */
class YiiException extends \DomainException
{
    /**
     * @var array
     */
    public $data = [];

    /**
     * YiiException constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
        parent::__construct('', 0, null);
    }
}