<?php
/**
 * Created by PhpStorm.
 * User: mattsue15@163.com
 * Date: 2019/5/15
 * Time: 10:26
 */

namespace app\common\controller;


use app\common\response\RestfulResult;
use think\Controller;

class BaseController extends Controller
{
    protected function json(RestfulResult $restfulResult)
    {
        return json($restfulResult->toArray());
    }
}