<?php

namespace DSI\Service;

class Sysctl
{
    public static $version = '1.3p';

    public static function echoVersion()
    {
        echo 'v=' . self::$version;
    }
}