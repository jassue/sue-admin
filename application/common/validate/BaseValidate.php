<?php
/**
 * Created by PhpStorm.
 * User: mattsue15@163.com
 * Date: 2019/4/3
 * Time: 20:49
 */

namespace app\common\validate;


use think\Validate;
use think\facade\Request;
use think\exception\ValidateException;
use app\common\exception\ExceptionCode;

class BaseValidate extends Validate
{
    public function goCheck(string $scene = '')
    {
        $params = Request::param();
        $result = $this->scene($scene)->batch()->check($params);
        if (!$result) {
            throw new ValidateException($this->error, ExceptionCode::CODE_VALIDATE_ERROR);
        } else {
            return true;
        }
    }

    public function getDataByRule(array $arrays)
    {
        $newArray = [];
        foreach ($this->rule as $key => $value) {
            $newArray[$key] = $arrays[$key];
        }
        return $newArray;
    }

    public function checkWithGetDataByRule(array $arrays, string $scene = '')
    {
        $this->goCheck($scene);
        return $this->getDataByRule($arrays);
    }
}