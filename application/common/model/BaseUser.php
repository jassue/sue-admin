<?php
/**
 * Created by PhpStorm.
 * User: mattsue15@163.com
 * Date: 2019/4/2
 * Time: 23:56
 */

namespace app\common\model;


class BaseUser extends BaseModel
{
    protected $hidden = [
        'password'
    ];

    public static function makePassword(string $password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function setPassword(string $password)
    {
        $this->setAttr('password', self::makePassword($password));
    }

    public function checkPassword(string $password)
    {
        return password_verify($password, $this->getAttr('password'));
    }
}