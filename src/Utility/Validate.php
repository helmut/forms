<?php 

namespace Helmut\Forms\Utility;

class Validate {
    
    public static function required($var) 
    {
        if (is_null($var)) return false;
        else if (is_string($var) && trim($var) === '') return false;
        return true;
    }

    public static function stringMin($var, $min) 
    {
        return strlen($var) >= $min;
    }

    public static function stringMax($var, $max) 
    {
        return strlen($var) <= $max;
    }

    public static function alpha($var)
    {
        return is_string($var) && preg_match('/^[\pL\pM]+$/u', $var);
    }

    public static function alphaNum($var)
    {
        if ( ! is_string($var) && ! is_numeric($var)) return false;
        return preg_match('/^[\pL\pM\pN]+$/u', $var);
    }

    public static function alphaDash($var)
    {
        if ( ! is_string($var) && ! is_numeric($var)) return false;
        return preg_match('/^[\pL\pM\pN_-]+$/u', $var);
    }

    public static function in($var, $array)
    {
        return in_array($var, $array);
    }

    public static function notIn($var, $array)
    {
        return ! in_array($var, $array);
    }

    public static function email($var)
    {
        return filter_var($var, FILTER_VALIDATE_EMAIL) !== false;
    }

    public static function numeric($var)
    {
        return is_numeric($var);
    }

    public static function numericMin($var, $min) 
    {
        return $var >= $min;
    }

    public static function numericMax($var, $max) 
    {
        return $var <= $max;
    }

    public static function integer($var)
    {
        return filter_var($var, FILTER_VALIDATE_INT) !== false;
    }

    public static function matches($var1, $var2) 
    {
        return strcmp($var1, $var2) === 0;
    }

}
