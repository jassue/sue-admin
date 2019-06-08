<?php
/**
 * Created by PhpStorm.
 * User: mattsue15@163.com
 * Date: 2019/6/8
 * Time: 16:04
 */

namespace app\admin\exception;


use app\common\exception\BusinessException;
use app\common\exception\ExceptionCode;

class IllegalOperatedDataException extends BusinessException
{
    public function __construct($message = null, int $code = ExceptionCode::CODE_ILLEGAL_OPERATED_FOR_ADMIN_AUTH)
    {
        parent::__construct($message ?? '非法操作', $code);
    }
}