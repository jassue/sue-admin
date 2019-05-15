<?php
/**
 * Created by PhpStorm.
 * User: mattsue15@163.com
 * Date: 2019/4/2
 * Time: 23:42
 */

namespace app\common\response;


use app\common\exception\ExceptionCode;

class SuccessResult extends RestfulResult
{
    /**
     * SuccessResult constructor.
     * @param int $code
     * @param null $data
     * @param string $message
     */
    public function __construct($code = ExceptionCode::CODE_SUCCESS, $data = null, $message = 'success')
    {
        parent::__construct($code, $data, $message);
    }
}