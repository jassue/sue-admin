<?php
/**
 * Created by PhpStorm.
 * User: mattsue15@163.com
 * Date: 2019/4/2
 * Time: 23:51
 */

namespace app\common\exception;


use Exception;

class BusinessException extends Exception
{
    /**
     * BusinessException constructor.
     * @param string $message
     * @param int $code
     */
    public function __construct($message = null, $code = ExceptionCode::CODE_DEFAULT)
    {
        parent::__construct($message, $code, null);
    }
}