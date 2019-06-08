<?php
/**
 * Created by PhpStorm.
 * User: mattsue15@163.com
 * Date: 2019/6/8
 * Time: 15:56
 */

namespace app\admin\exception;


use app\common\exception\BusinessException;
use app\common\exception\ExceptionCode;

class IllegalAddDataException extends BusinessException
{
    public function __construct($message = null, int $code = ExceptionCode::CODE_ILLEGAL_ADD_DATA)
    {
        parent::__construct($message ?? '非法添加数据', $code);
    }
}