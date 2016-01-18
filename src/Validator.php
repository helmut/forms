<?php 

namespace Helmut\Forms;

class Validator {
	
	public function required($var) 
	{
		if (is_null($var)) return false;
        else if (is_string($var) && trim($var) === '') return false;
        return true;
	}

	public function stringMin($var, $min) 
	{
		return strlen($var) >= $min;
	}

	public function stringMax($var, $max) 
	{
		return strlen($var) <= $max;
	}

	public function alpha($var)
	{
		return is_string($var) && preg_match('/^[\pL\pM]+$/u', $var);
	}

	public function alphaNum($var)
	{
 		if (! is_string($var) && ! is_numeric($var)) return false;
        return preg_match('/^[\pL\pM\pN]+$/u', $var);
    }

	public function alphaDash($var)
	{
 		if (! is_string($var) && ! is_numeric($var)) return false;
        return preg_match('/^[\pL\pM\pN_-]+$/u', $var);
	}

	public function in($var, $array)
	{
 		return in_array($var, $array);
	}

	public function notIn($var, $array)
	{
 		return ! in_array($var, $array);
	}

	public function email($var)
	{
		return filter_var($var, FILTER_VALIDATE_EMAIL) !== false;
	}

	public function numeric($var)
	{
		return is_numeric($var);
	}

	public function numericMin($var, $min) 
	{
		return $var >= $min;
	}

	public function numericMax($var, $max) 
	{
		return $var <= $max;
	}

	public function integer($var)
	{
		return filter_var($var, FILTER_VALIDATE_INT) !== false;
	}

	public function snake($var)
	{
		if ( ! ctype_lower($var)) {
    		$var = preg_replace('/\s+/', '', $var);
    		$var = strtolower(preg_replace('/(.)(?=[A-Z])/', '$1'.'_', $var));
		}
		return $var;
	}

	public function studly($var)
	{
		return str_replace(' ', '', ucwords(str_replace(['-', '_'], ' ', $var)));
	}

}
