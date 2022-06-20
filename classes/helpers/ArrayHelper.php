<?php

class ArrayHelper
{
    public static function trim($val)
    {
        $val = is_array($val) ? array_map(['ArrayHelper', 'trim'], $val) : (is_string($val) ? trim($val) : $val);

        return $val;
    }
}
