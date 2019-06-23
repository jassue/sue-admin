<?php
/**
 * Created by PhpStorm.
 * User: mattsue15@163.com
 * Date: 2019/6/12
 * Time: 20:30
 */

namespace app\admin\controller;


use app\admin\exception\IllegalOperatedDataException;
use app\common\response\SuccessResult;
use app\common\validate\AdminRuleValidate;
use app\service\facade\AdminRules;
use think\Request;

class AdminRule extends AdminBaseController
{
    /**
     * @return \think\response\View
     */
    public function index()
    {
        return view('index', [
            'ruleList'  => AdminRules::getChildList()
        ]);
    }

    /**
     * @param Request $request
     * @return \think\response\View
     */
    public function create(Request $request)
    {
        return view('info', [
            'ruleList'  => AdminRules::getChildList(),
            'parent_id' => $request->get('pid', 1),
        ]);
    }

    /**
     * @param Request $request
     * @return \think\response\Json
     */
    public function save(Request $request)
    {
        (new AdminRuleValidate())->goCheck();
        AdminRules::create($request->post('parent_id'), $request->post('name'), $request->post('url'));
        return $this->json(new SuccessResult());
    }

    /**
     * @param Request $request
     * @return \think\response\View
     */
    public function edit(Request $request)
    {
        (new AdminRuleValidate())->goCheck('edit');
        $info = AdminRules::getById($request->get('id'));
        return view('info', [
            'ruleList'  => AdminRules::getChildList(),
            'info'      => $info,
            'parent_id' => $info->parent_id
        ]);
    }

    /**
     * @param Request $request
     * @return \think\response\Json
     */
    public function update(Request $request)
    {
        (new AdminRuleValidate())->goCheck('update');
        AdminRules::update($request->post());
        return $this->json(new SuccessResult());
    }

    /**
     * @param Request $request
     * @return \think\response\Json
     * @throws IllegalOperatedDataException
     */
    public function delete(Request $request)
    {
        if ($request->post('id') <= 1)
            throw new IllegalOperatedDataException();
        AdminRules::delete($request->post('id'));
        return $this->json(new SuccessResult());
    }
}