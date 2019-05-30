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
     * @param null $data
     * @param string $message
     */
    public function __construct($data = null, $message = 'success')
    {
        parent::__construct(ExceptionCode::CODE_SUCCESS, $data, $message);
    }
}