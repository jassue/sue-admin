<?php
/**
 * Created by PhpStorm.
 * User: mattsue15@163.com
 * Date: 2019/4/2
 * Time: 23:49
 */

namespace app\common\exception;


use think\exception\Handle;
use Exception;
use think\exception\ValidateException;
use think\facade\Log;

class ExceptionHandle extends Handle
{
    /**
     * @param Exception $e
     * @return \think\Response|\think\response\Json
     */
    public function render(Exception $e)
    {
        if ($e instanceof ValidateException) {
            Log::close();
            return json([
                'code'  => ExceptionCode::CODE_VALIDATE_ERROR,
                'data'  => $e->getError(),
                'message'   => '数据验证失败'
            ]);
        }
        if ($e instanceof BusinessException) {
            Log::close();
            return json([
                'code'  => $e->getCode(),
                'data'  => null,
                'message'   => $e->getMessage()
            ]);
        }
        return parent::render($e);
    }
}