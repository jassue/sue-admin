<?php
/**
 * Created by PhpStorm.
 * User: mattsue15@163.com
 * Date: 2019/4/15
 * Time: 23:42
 */

namespace app\common\exception;


class InvalidPasswordException extends BusinessException
{
    public function __construct($message = null, $code = ExceptionCode::CODE_INVALID_PASSWORD)
    {
        parent::__construct($message ?? '密码错误', $code);
    }
}