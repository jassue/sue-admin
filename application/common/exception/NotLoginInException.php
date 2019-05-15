<?php
/**
 * Created by PhpStorm.
 * User: mattsue15@163.com
 * Date: 2019/4/18
 * Time: 21:53
 */

namespace app\common\exception;


class NotLoginInException extends BusinessException
{
    public function __construct($message = null, $code = ExceptionCode::CODE_NOT_LOGIN_ERROR)
    {
        parent::__construct($message ?? '您尚未登录，请先登录', $code);
    }
}