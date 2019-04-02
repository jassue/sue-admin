<?php
/**
 * Created by PhpStorm.
 * User: mattsue15@163.com
 * Date: 2019/4/2
 * Time: 23:42
 */

namespace app\common\response;


class SuccessResult extends RestfulResult
{
    public function __construct($data = null, string $message = 'success')
    {
        parent::__construct(0, $data, $message);
    }
}