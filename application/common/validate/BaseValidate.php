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
    /**
     * @param string $scene
     * @param bool $batch
     * @return bool
     */
    public function goCheck($scene = '', $batch = true)
    {
        $params = Request::param();
        if ($batch)
            $result = $this->scene($scene)->batch()->check($params);
        else
            $result = $this->scene($scene)->check($params);
        if (!$result)
            throw new ValidateException($this->error, ExceptionCode::CODE_VALIDATE_ERROR);
        else
            return true;
    }

    /**
     * @param array $arrays
     * @return array
     */
    public function getDataByRule(array $arrays)
    {
        $newArray = [];
        foreach ($this->rule as $key => $value) {
            $newArray[$key] = $arrays[$key];
        }
        return $newArray;
    }

    /**
     * @param array $arrays
     * @param string $scene
     * @return array
     */
    public function checkWithGetDataByRule(array $arrays, $scene = '')
    {
        $this->goCheck($scene);
        return $this->getDataByRule($arrays);
    }

    /**
     * @param $value
     * @param $rule
     * @param $data
     * @param $field
     * @return bool
     */
    protected function exists($value, $rule, $data, $field)
    {
        $rules = explode(',', $rule);
        $count = count($rules);
        if ($count == 1) {
            $where[] = [$field, '=', $value];
        } else {
            $where[] = [$rules[1], '=', $value];
        }
        if ($count == 3) {
            $where[] = ['id', '=', $rules[2]];
        } elseif ($count == 4) {
            $where[] = [$rules[3], '=', $rules[2]];
        }
        return model($rules[0])->where($where)->count() > 0 ? true : false;
    }
}