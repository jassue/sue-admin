<?php
/**
 * Created by PhpStorm.
 * User: mattsue15@163.com
 * Date: 2019/4/14
 * Time: 20:49
 */

namespace app\common\enum;


class BaseStatus
{
    const ENABLE = 1;
    const DISABLE = 0;

    public static $statusMap = [
        self::ENABLE    => '启用',
        self::DISABLE   => '禁用',
    ];

}