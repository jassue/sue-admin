<?php
/**
 * Created by PhpStorm.
 * User: mattsue15@163.com
 * Date: 2019/4/2
 * Time: 23:48
 */

namespace app\common\exception;


class ExceptionCode
{
    const CODE_DEFAULT = 10000;
    const CODE_VALIDATE_ERROR = 10001;
    const CODE_INVALID_PASSWORD = 10002;
    const CODE_NOT_LOGIN_ERROR = 10003;
    const CODE_NO_AUTH_FOR_ACCESS = 10004;
}