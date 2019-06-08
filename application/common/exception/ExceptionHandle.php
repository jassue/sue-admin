<?php
/**
 * Created by PhpStorm.
 * User: mattsue15@163.com
 * Date: 2019/4/2
 * Time: 23:49
 */

namespace app\common\exception;


use app\common\response\RestfulResult;
use think\exception\Handle;
use Exception;
use think\exception\ValidateException;
use think\facade\Log;
use think\facade\Request;

class ExceptionHandle extends Handle
{
    /**
     * @param Exception $e
     * @return \think\Response|\think\response\Json|\think\response\Redirect
     */
    public function render(Exception $e)
    {
        if ($e instanceof ValidateException) {
            return $this->renderValidateException($e);
        }
        if ($e instanceof BusinessException) {
            return $this->renderBusinessException($e);
        }
        return parent::render($e);
    }

    /**
     * @param ValidateException $e
     * @return \think\response\Json|\think\response\Redirect
     */
    private function renderValidateException(ValidateException $e)
    {
        Log::close();
        if (Request::isGet())
            return redirect(Request::server('HTTP_REFERER') ?? '/');
        return json((new RestfulResult(ExceptionCode::CODE_VALIDATE_ERROR, null, $e->getError()))->toArray());
    }

    /**
     * @param BusinessException $e
     * @return \think\response\Json|\think\response\Redirect
     */
    private function renderBusinessException(BusinessException $e)
    {
        Log::close();
        if (Request::isGet())
            return redirect(Request::server('HTTP_REFERER') ?? '/');
        return json((new RestfulResult($e->getCode(), null, $e->getMessage()))->toArray());
    }
}