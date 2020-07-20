<?php
namespace common\base;

use yii\base\UserException;

/**
* 无效签名异常
*/
class InvalidSignatureException extends UserException
{
    public $statusCode = 1003;
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
        return '无效签名';
    }
}