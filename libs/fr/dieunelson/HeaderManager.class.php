<?php

namespace fr\dieunelson;

class HeaderManager{

    public static function Location(string $location)
    {
        $header = "Location: $location";
        HeaderManager::setManual($header);
        return $header;
    }

    public static function Accept(string $accept)
    {
        $header = "Accept: $accept";
        HeaderManager::setManual($header);
        return $header;
    }

    public static function ContentType(string $type)
    {
        $header = "Content-Type: $type";
        HeaderManager::setManual($header);
        return $header;
    }

    public static function AllowMethods(array $methods)
    {
        $header = "Access-Control-Allow-Methods: ".\implode(",", $methods);
        HeaderManager::setManual($header);
        return $header;
    }

    public static function AllowOrign(string $origin)
    {
        $header = "Access-Control-Allow-Origin: $origin";
        HeaderManager::setManual($header);
        return $header;
    }

    public static function AllowHeaders(array $headers)
    {
        $header = "Access-Control-Allow-Headers: ".\implode(",", $headers);
        HeaderManager::setManual($header);
        return $header;
    }

    public static function Set(string $name, string $value)
    {
        $header = "$name: $value";
        HeaderManager::setManual($header);
        return $header;
    }

    public static function setManual(string $value)
    {
        header($value);
    }


}