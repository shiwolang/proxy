<?php
/**
 * Created by zhouzhongyuan.
 * User: zhouzhongyuan
 * Date: 2015/11/28
 * Time: 17:50
 */

namespace shiwolang\event;


class Event
{
    protected static $definedClasses = [];
    protected static $_instance      = [];

    protected $events = [];

    protected function __construct($events = null)
    {
        if ($events !== null) {
            $this->events = $events;

            return;
        }
        static::$definedClasses = get_declared_classes();

        $allClass = static::$definedClasses;

        foreach ($allClass as $key => $className) {
            $reflectionClass = new \ReflectionClass($className);
            if (!in_array(EventHander::class, $reflectionClass->getInterfaceNames())) {
                var_dump($reflectionClass->getInterfaceNames());
            }
        }
    }


    public static function init($name = "default", $events = null, $reinit = false)
    {
        if (!isset(static::$_instance[$name]) || $reinit) {
            static::$_instance[$name] = new static($events);
        } else {
            throw new EventException("The Proxy name of (" . $name . ") does exist");
        }

        return static::$_instance[$name];
    }

    /**
     * @param string $name
     * @return self
     * @throws EventException
     */
    public static function instance($name = "default")
    {
        if (isset(static::$_instance[$name])) {
            return static::$_instance[$name];
        } else {
            throw new EventException("The Proxy name of (" . $name . ") does not exist");
        }
    }


    public function proxy(&$object, &$objectCopy)
    {
        $objectCopy = $object;

        return $object = new ProxyObject($object);
    }
}