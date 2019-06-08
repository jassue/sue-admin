<?php
/**
 * Created by PhpStorm.
 * User: mattsue15@163.com
 * Date: 2019/6/4
 * Time: 14:33
 */

namespace app\admin\controller;


use app\admin\exception\IllegalAddDataException;
use app\admin\exception\IllegalOperatedDataException;
use app\common\response\SuccessResult;
use app\common\validate\AdminRoleValidate;
use app\service\facade\AdminRoles;
use app\service\facade\AdminRules;
use think\Db;
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

    /**
     * @param Request $request
     * @return \think\response\Json
     * @throws IllegalAddDataException
     */
    public function save(Request $request)
    {
        (new AdminRoleValidate())->goCheck();
        if (in_array(1, $request->post('rules')))
            throw new IllegalAddDataException();
        $adminRole = AdminRoles::create($request->post('name'));
        AdminRoles::allocationRules($adminRole, $request->post('rules'));
        return $this->json(new SuccessResult());
    }

    /**
     * @param Request $request
     * @return \think\response\View
     */
    public function edit(Request $request)
    {
        (new AdminRoleValidate())->goCheck('edit');
        return view('info', [
            'info'     => AdminRoles::getInfoById($request->get('id')),
            'ruleList' => AdminRules::getChildList(),
        ]);
    }

    /**
     * @param Request $request
     * @return \think\response\Json
     */
    public function update(Request $request)
    {
        (new AdminRoleValidate())->goCheck('update');
        Db::transaction(function () use ($request) {
            AdminRoles::update($request->post());
            AdminRoles::toggleRules(AdminRoles::getById($request->post('id')), $request->post('rules'));
        });
        return $this->json(new SuccessResult());
    }

    /**
     * @param Request $request
     * @return \think\response\Json
     * @throws IllegalOperatedDataException
     */
    public function delete(Request $request)
    {
        $ids = $request->post('ids');
        if (in_array(1, $ids))
            throw new IllegalOperatedDataException();
        AdminRoles::delete($ids);
        return $this->json(new SuccessResult());
    }
}