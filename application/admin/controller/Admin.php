<?php
/**
 * Created by PhpStorm.
 * User: mattsue15@163.com
 * Date: 2019/4/15
 * Time: 20:49
 */

namespace app\admin\controller;


use app\admin\exception\IllegalOperatedDataException;
use app\service\facade\AdminRoles;
use app\service\facade\Admins;
use app\common\exception\InvalidPasswordException;
use app\common\response\SuccessResult;
use app\common\validate\AdminValidate;
use think\Db;
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
     * @return \think\response\Redirect
     */
    public function logout()
    {
        Admins::logout();
        return redirect('/admin/login');
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
     */
    public function toggleStatus(Request $request)
    {
        (new AdminValidate())->goCheck('toggleStatus');
        Admins::setStatus(Admins::getById($request->post('id')), $request->post('status'));
        return $this->json(new SuccessResult());
    }

    /**
     * @param Request $request
     * @return \think\response\View
     */
    public function edit(Request $request)
    {
        (new AdminValidate())->goCheck('edit');
        return view('info', [
            'info' => Admins::getInfoById($request->get('id')),
            'roleList' => AdminRoles::getList()
        ]);
    }

    /**
     * @param Request $request
     * @return \think\response\Json
     */
    public function update(Request $request)
    {
        (new AdminValidate())->goCheck('update');
        $args = $request->post();
        if (empty($args['password']))
            unset($args['password']);
        Db::transaction(function () use ($args) {
            Admins::update($args);
            Admins::toggleRoles(Admins::getById($args['id']), $args['roles']);
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
        Admins::delete($ids);
        return $this->json(new SuccessResult());
    }

    /**
     * @return \think\response\View
     */
    public function profile()
    {
        return view('profile', [
            'info' => Admins::getProfile(Admins::user())
        ]);
    }

    /**
     * @param Request $request
     * @return \think\response\Json
     */
    public function setProfile(Request $request)
    {
        (new AdminValidate())->goCheck('updateProfile');
        $args = $request->post();
        if (empty($args['password']))
            unset($args['password']);
        if (empty($args['avatar']))
            unset($args['avatar']);
        Admins::updateProfile(Admins::user(), $args);
        return $this->json(new SuccessResult());
    }
}