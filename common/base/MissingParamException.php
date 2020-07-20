<?php
namespace common\base;

use yii\base\UserException;

/**
* 缺少参数异常
*/
class MissingParamException extends UserException
{
    public $statusCode = 1002;
    /**
     * Constructor.
     * @param string $message error message
     * @param integer $code error code
     * @param \Exception $previous The previous exception used for the exception chaining.
     */
    public function __construct($message = null, \Exception $previous = null)
    {
        parent::__construct($message, $this->statusCode, $previous);
    }

    /**
     * @return string the user-friendly name of this exception
     */
    public function getName()
    {
        return '缺少参数';
    }
}