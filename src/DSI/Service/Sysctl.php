<?php

namespace DSI\Service;

class Sysctl
{
    public static $version = '1.3f';

    public static function echoVersion()
    {
        echo 'v=' . self::$version;
    }
}