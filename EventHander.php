<?php
/**
 * Created by zhouzhongyuan.
 * User: zhouzhongyuan
 * Date: 2015/12/8
 * Time: 17:17
 */

namespace shiwolang\event;


interface EventHander
{
    public function run($eventName, $params);
}