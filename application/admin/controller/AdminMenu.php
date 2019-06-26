<?php
/**
 * Created by PhpStorm.
 * User: mattsue15@163.com
 * Date: 2019/6/24
 * Time: 23:05
 */

namespace app\admin\controller;


use app\common\response\SuccessResult;
use app\common\validate\AdminMenuValidate;
use app\service\facade\AdminMenus;
use think\Request;

class AdminMenu extends AdminBaseController
{
    /**
     * @return \think\response\View
     */
    public function index()
    {
        return view('index', [
            'menuAllList' => AdminMenus::getChildList()
        ]);
    }

    /**
     * @param Request $request
     * @return \think\response\View
     */
    public function create(Request $request)
    {
        return view('info', [
            'menuAllList'  => AdminMenus::getChildList(),
            'parent_id' => $request->get('pid', 0),
        ]);
    }

    /**
     * @param Request $request
     * @return \think\response\Json
     */
    public function save(Request $request)
    {
        (new AdminMenuValidate())->goCheck();
        AdminMenus::create(
            $request->post('parent_id'),
            $request->post('name'),
            $request->post('icon'),
            $request->post('url')
        );
        return $this->json(new SuccessResult());
    }

    /**
     * @param Request $request
     * @return \think\response\View
     */
    public function edit(Request $request)
    {
        (new AdminMenuValidate())->goCheck('edit');
        $info = AdminMenus::getById($request->get('id'));
        return view('info', [
            'menuAllList'  => AdminMenus::getChildList(),
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
        (new AdminMenuValidate())->goCheck('update');
        AdminMenus::update($request->post());
        return $this->json(new SuccessResult());
    }

    /**
     * @param Request $request
     * @return \think\response\Json
     */
    public function delete(Request $request)
    {
        AdminMenus::delete($request->post('id'));
        return $this->json(new SuccessResult());
    }
}