<?php
/**
 * Created by PhpStorm.
 * User: mattsue15@163.com
 * Date: 2019/4/18
 * Time: 21:17
 */

namespace app\common\facade;


use think\Facade;

class Auth extends Facade
{
    protected static function getFacadeClass()
    {
        return 'app\common\service\Auth';
    }
}