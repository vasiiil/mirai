<?php


class Checker
{
    public static function string($str, $default = null)
    {
        return is_string($str) && trim($str) ? trim($str) : $default;
    }

    public static function int($val, $default = null)
    {
        return $val !== null && is_numeric($val) && (string)intval($val) === (string) $val ? (int) $val : $default;
    }

    public static function positiveInt($val, $default = null)
    {
        return self::int($val) && $val > 0 ? (int)$val : $default;
    }
}
