<?php

namespace DSI\Service;

class Sysctl
{
    public static $version = '1.4c.4';

    public static function echoVersion()
    {
        echo 'v=' . self::$version;
    }
}