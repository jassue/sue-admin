<?php
/**
 * Created by PhpStorm.
 * User: mattsue15@163.com
 * Date: 2019/4/18
 * Time: 21:05
 */

namespace app\common\service;


use app\common\model\BaseUser;
use think\facade\Session;

class Auth
{
    protected $GUARD_NAME = 'user';

    /**
     * @param string $name
     * @return $this
     */
    public function guard(string $name)
    {
        $this->GUARD_NAME = $name;
        return $this;
    }

    /**
     * @param BaseUser $user
     */
    public function login(BaseUser $user)
    {
        Session::set($this->GUARD_NAME, $user);
    }

    /**
     * @return mixed
     */
    public function user()
    {
        return Session::get($this->GUARD_NAME);
    }

    /**
     * @return bool
     */
    public function check()
    {
        return Session::has($this->GUARD_NAME) ? true : false;
    }
}