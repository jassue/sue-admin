<?php
/**
 * Created by PhpStorm.
 * User: mattsue15@163.com
 * Date: 2019/4/18
 * Time: 22:10
 */

namespace app\admin\exception;


use app\common\exception\BusinessException;
use app\common\exception\ExceptionCode;

class NoAuthForAccessException extends BusinessException
{
    public function __construct($message = null, $code = ExceptionCode::CODE_NO_AUTH_FOR_ACCESS)
    {
        parent::__construct($message ?? '您无权访问该功能', $code);
    }
}