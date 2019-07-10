<?php
/**
 * Created by PhpStorm.
 * User: mattsue15@163.com
 * Date: 2019/6/30
 * Time: 20:48
 */

namespace app\service\facade;


use think\Facade;

class UploadImage extends Facade
{
    protected static function getFacadeClass()
    {
        return 'app\service\UploadImage';
    }
}