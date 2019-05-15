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
     * @param Request $request
     * @return \think\response\View
     */
    public function index(Request $request)
    {
        $keywords = [];
        $length = $request->get('length', 10);
        $username = $request->get('username', '');
        $name = $request->get('name', '');
        !empty($username) && $keywords['username'] = $username;
        !empty($name) && $keywords['name'] = $name;
        $list = Admins::getPaginateListWithRoles($length, $username, $name);
        return view('index', [
            'adminList' => $list,
            'keywords' => $keywords,
            'length' => $length
        ]);
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
     * @param $id
     * @return \think\response\View
     * @throws AdminCantBeOperatedException
     */
    public function edit($id)
    {
        if ($id == 1)
            throw new AdminCantBeOperatedException();
        (new AdminValidate())->goCheck('edit');
        return view('info', [
            'info' => Admins::getInfoWithRolesById($id),
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