<?php
/**
 * Created by PhpStorm.
 * User: mattsue15@163.com
 * Date: 2019/6/8
 * Time: 20:00
 */

namespace app\service;


use app\common\model\BaseUser;

interface UserInterface
{
    public function login(BaseUser $user);

    public function logout();

    public function checkLogin();

    public function user();
}