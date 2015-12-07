<?php
/**
 * Created by zhouzhongyuan.
 * User: zhouzhongyuan
 * Date: 2015/11/28
 * Time: 17:50
 */

namespace shiwolang\proxy;


class Proxy
{
    protected static $_instance = [];

    protected $object          = null;
    protected $reflectionClass = null;


    public static function init($name = "default", $reinit = false)
    {
        if (!isset(self::$_instance[$name]) || $reinit) {
            self::$_instance[$name] = new static();
        } else {
            throw new ProxyException("The Proxy name of (" . $name . ") does exist");
        }

        return self::$_instance[$name];
    }

    public static function m($name = "default")
    {
        if (isset(self::$_instance[$name])) {
            return self::$_instance[$name];
        } else {
            throw new ProxyException("The Proxy name of (" . $name . ") does not exist");
        }
    }


    public function proxy(&$object)
    {
        $this->reflectionClass = new \ReflectionClass($object);

        $this->object = $object;
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