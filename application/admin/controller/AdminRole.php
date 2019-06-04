<?php
/**
 * Created by PhpStorm.
 * User: mattsue15@163.com
 * Date: 2019/6/4
 * Time: 14:33
 */

namespace app\admin\controller;


use app\common\response\SuccessResult;
use app\service\facade\AdminRoles;
use app\service\facade\AdminRules;
use think\Request;

class AdminRole extends AdminBaseController
{
    /**
     * @return \think\response\View
     */
    public function index()
    {
        return view('index');
    }

    /**
     * @param Request $request
     * @return \think\response\Json
     */
    public function list(Request $request)
    {
        $paginator = AdminRoles::getPaginateList(
            $request->post('page', 1),
            $request->post('length', 10)
        );
        $data['draw'] = (int)$request->post('draw');
        $data['count'] = $paginator->total();
        $data['data'] = $paginator->items();
        return $this->json(new SuccessResult($data));
    }

    /**
     * @return \think\response\View
     */
    public function create()
    {
        return view('create', [
            'ruleList' => AdminRules::getChildList()
        ]);
    }
}