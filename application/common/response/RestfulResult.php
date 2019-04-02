<?php
/**
 * Created by PhpStorm.
 * User: mattsue15@163.com
 * Date: 2019/4/2
 * Time: 23:30
 */

namespace app\common\response;


class RestfulResult
{
    private $code;
    private $data;
    private $message;

    public function __construct(int $code, $data = null, string $message = '')
    {
        $this->code = $code;
        $this->data = $data;
        $this->message = $message;
    }

    public function __get($name)
    {
        return $this->name;
    }

    public function toArray()
    {
        return ['code' => $this->code, 'data' => $this->data, 'message' => $this->message];
    }

    public function toJson()
    {
        return json_encode($this->toArray());
    }

    public function __toString()
    {
        return $this->toJson();
    }
}