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

    /**
     * @param string $password
     * @return bool|string
     */
    public static function makePassword(string $password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password)
    {
        $this->setAttr('password', self::makePassword($password));
    }

    /**
     * @param string $password
     * @return bool
     */
    public function checkPassword(string $password)
    {
        return password_verify($password, $this->getAttr('password'));
    }
}