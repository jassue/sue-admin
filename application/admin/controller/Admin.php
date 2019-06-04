<?php
/**
 * Created by PhpStorm.
 * User: mattsue15@163.com
 * Date: 2019/4/15
 * Time: 20:49
 */

namespace app\admin\controller;


use app\admin\exception\AdminCantBeOperatedException;
use app\service\facade\AdminRoles;
use app\service\facade\Admins;
use app\common\exception\InvalidPasswordException;
use app\common\response\SuccessResult;
use app\common\validate\AdminValidate;
use think\Request;

class Admin extends AdminBaseController
{
    /**
     * @return \think\response\View
     */
    public function loginPage()
    {
        return view('/login');
    }

    /**
     * @param Request $request
     * @return \think\response\Json
     * @throws InvalidPasswordException
     */
    public function login(Request $request)
    {
        (new AdminValidate())->goCheck('login', false);
        $admin = Admins::getByUsername($request->post('username'));
        $result = Admins::checkPassword($admin, $request->post('password'));
        if (!$result)
            throw new InvalidPasswordException();
        Admins::login($admin);
        return $this->json(new SuccessResult());
    }

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
        $paginator = Admins::getPaginateList(
            $request->post('page', 1),
            $request->post('length', 10),
            $request->post('username'),
            $request->post('name')
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
            'roleList' => AdminRoles::getList()
        ]);
    }

    /**
     * @param Request $request
     * @return \think\response\Json
     */
    public function save(Request $request)
    {
        (new AdminValidate())->goCheck();
        $admin = Admins::create(
            $request->post('username'),
            $request->post('name'),
            $request->post('password'),
            $request->post('mobile')
        );
        Admins::bindRoles($admin, $request->post('roles'));
        return $this->json(new SuccessResult());
    }

    /**
     * @param Request $request
     * @return \think\response\Json
     * @throws AdminCantBeOperatedException
     */
    public function toggleStatus(Request $request)
    {
        if ($request->post('id') == 1)
            throw new AdminCantBeOperatedException();
        (new AdminValidate())->goCheck('toggleStatus');
        Admins::setStatus(Admins::getById($request->post('id')), $request->post('status'));
        return $this->json(new SuccessResult());
    }

    /**
     * @param Request $request
     * @return \think\response\View
     * @throws AdminCantBeOperatedException
     */
    public function edit(Request $request)
    {
        if ($request->get('id') == 1)
            throw new AdminCantBeOperatedException();
        (new AdminValidate())->goCheck('edit');
        return view('info', [
            'info' => Admins::getInfoWithRolesById($request->get('id')),
            'roleList' => AdminRoles::getList()
        ]);
    }

    /**
     * @param Request $request
     * @return \think\response\Json
     * @throws AdminCantBeOperatedException
     */
    public function update(Request $request)
    {
        if ($request->post('id') == 1)
            throw new AdminCantBeOperatedException();
        (new AdminValidate())->goCheck('update');
        $args = $request->post();
        if (empty($args['password']))
            unset($args['password']);
        Admins::update($args);
        Admins::toggleRoles(Admins::getById($args['id']), $args['roles']);
        return $this->json(new SuccessResult());
    }

    /**
     * @param Request $request
     * @return \think\response\Json
     * @throws AdminCantBeOperatedException
     */
    public function delete(Request $request)
    {
        $ids = $request->post('ids');
        if (in_array(1, $ids))
            throw new AdminCantBeOperatedException();
        Admins::delete($ids);
        return $this->json(new SuccessResult());
    }
}