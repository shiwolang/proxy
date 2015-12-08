<?php
/**
 * Created by zhouzhongyuan.
 * User: zhouzhongyuan
 * Date: 2015/12/7
 * Time: 16:09
 */

namespace shiwolang\event;


class ProxyObject
{
    public static $publicHanders   = [];
    protected     $object          = null;
    protected     $reflectionClass = null;

    public function __construct($object)
    {
        $this->object = $object;

        $this->reflectionClass = new \ReflectionClass($object);
    }

    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->object, $name], $arguments);
    }


    public function __debugInfo()
    {
        return $this->object;
    }


    public function __get($name)
    {
        return $this->object->$name;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }
}