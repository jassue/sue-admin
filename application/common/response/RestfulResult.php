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

    /**
     * RestfulResult constructor.
     * @param int $code
     * @param null $data
     * @param string $message
     */
    public function __construct(int $code, $data = null, $message = '')
    {
        $this->code = $code;
        $this->data = $data;
        $this->message = $message;
    }

    /**
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return ['code' => $this->code, 'data' => $this->data, 'message' => $this->message];
    }

    /**
     * @return false|string
     */
    public function toJson()
    {
        return json_encode($this->toArray());
    }

    /**
     * @return false|string
     */
    public function __toString()
    {
        return $this->toJson();
    }
}