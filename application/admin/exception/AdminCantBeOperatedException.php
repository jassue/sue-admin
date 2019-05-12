<?php
/**
 * Created by PhpStorm.
 * User: mattsue15@163.com
 * Date: 2019/5/3
 * Time: 20:13
 */

namespace app\admin\exception;


use app\common\exception\BusinessException;
use app\common\exception\ExceptionCode;

class AdminCantBeOperatedException extends BusinessException
{
    public function __construct($message = null, int $code = ExceptionCode::CODE_SYSTEM_ADMIN_CANNOT_BE_OPERATED)
    {
        parent::__construct($message ?? '系统内置管理员不能被操作', $code);
    }
}