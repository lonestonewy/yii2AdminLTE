<?php
namespace common\base;

use yii\base\UserException;

/**
* 渠道商订单号重复异常
*/
class OrderIdExistException extends UserException
{
    public $statusCode = 1006;
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
        return '渠道商订单号重复';
    }
}