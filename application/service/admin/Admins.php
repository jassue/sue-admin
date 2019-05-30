<?php
/**
 * Created by PhpStorm.
 * User: mattsue15@163.com
 * Date: 2019/4/14
 * Time: 20:33
 */

namespace app\service\admin;


use app\common\enum\BaseStatus;
use app\common\model\Admin;
use app\common\model\AdminRoleRelation;
use think\facade\Log;
use think\facade\Session;

class Admins
{
    /**
     * @param int $id
     * @return mixed
     */
    public function getById(int $id)
    {
        return Admin::getOrFail($id);
    }

    /**
     * @param string $username
     * @param string $name
     * @param string $password
     * @param string $mobile
     * @return Admin
     *
     */
    public function create(string $username, string $name, string $password, string $mobile)
    {
        return Admin::create([
            'username'     => $username,
            'name'         => $name,
            'password'     => Admin::makePassword($password),
            'mobile_phone' => $mobile,
            'status'       => BaseStatus::ENABLE
        ]);
    }

    /**
     * @param Admin $admin
     * @param array $roleIds
     */
    public function bindRoles(Admin $admin, array $roleIds)
    {
        $admin->roles()->saveAll($roleIds);
    }

    /**
     * @param string $username
     * @return array|\PDOStatement|string|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getByUsername(string $username)
    {
        return Admin::where('username', $username)->findOrEmpty();
    }

    /**
     * @param Admin $admin
     * @param string $password
     * @return bool
     */
    public function checkPassword(Admin $admin, string $password)
    {
        return $admin->checkPassword($password);
    }

    /**
     * @param Admin $admin
     * @param string $password
     */
    public function setPassword(Admin $admin, string $password)
    {
        $admin->setAttr('password', Admin::makePassword($password));
        $admin->save();
    }

    /**
     * @param Admin $admin
     */
    public function login(Admin $admin)
    {
        $admin->last_login_ip = request()->ip();
        $admin->last_login_time = time();
        $admin->save();
        Session::set('admin', $admin);
    }

    /**
     * @return bool
     */
    public function checkLogin()
    {
        return Session::has('admin') ? true : false;
    }

    /**
     * @return mixed
     */
    public function user()
    {
        return Session::get('admin');
    }

    /**
     * @param int $page
     * @param int $size
     * @param string $username
     * @param string $name
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function getPaginateList(int $page, int $size, string $username, string $name)
    {
        $where = [];
        !empty($username) && $where[] = ['username', 'like', "{$username}%"];
        !empty($name) && $where[] = ['name', 'like', "{$name}%"];
        return Admin::with('roles')
            ->where($where)
            ->paginate($size,false, ['page' => $page])
            ->each(
                function ($item) {
                    $item->roles_name = $item->roles->column('name');
                    unset($item->roles);
                }
            );
    }

    /**
     * @param array $post
     */
    public function update(array $post)
    {
        $data['id'] = $post['id'];
        isset($post['username']) && $data['username'] = $post['username'];
        isset($post['name']) && $data['name'] = $post['name'];
        isset($post['mobile_phone']) && $data['mobile_phone'] = $post['mobile'];
        isset($post['status']) && $data['status'] = $post['status'];
        isset($post['password']) && $data['password'] = Admin::makePassword($post['password']);
        Admin::update($data);
    }

    /**
     * @param Admin $admin
     * @param array $roleIds
     * @throws \think\Exception
     */
    public function toggleRoles(Admin $admin, array $roleIds)
    {
        $curRoleIds = $admin->roles()->select()->column('id');
        $needUnbindIds = [];
        foreach ($curRoleIds as $roleId) {
            if (!in_array($roleId, $roleIds))
                array_push($needUnbindIds, $roleId);
            else
                $roleIds = array_merge(array_diff($roleIds, array($roleId)));
        }
        !empty($needUnbindIds) && $this->unbindRoles($admin, $needUnbindIds);
        !empty($roleIds) && $admin->roles()->attach($roleIds);
    }

    /**
     * @param array $ids
     */
    public function delete(array $ids)
    {
        $roleRelationIds = AdminRoleRelation::whereIn('admin_id', $ids)->column('id');
        AdminRoleRelation::destroy($roleRelationIds);
        Admin::destroy($ids);
    }

    /**
     * @param Admin $admin
     * @param array $roleIds
     */
    public function unbindRoles(Admin $admin, array $roleIds)
    {
        $admin->roles()->detach($roleIds);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getInfoWithRolesById(int $id)
    {
        $admin = $this->getById($id);
        $admin->roleIds = $admin->roles()->select()->column('id');
        return $admin;
    }
}