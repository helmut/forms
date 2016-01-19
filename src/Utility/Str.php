<?php 

namespace Helmut\Forms\Utility;

class Str {

	public static function snake($var)
	{
		if ( ! ctype_lower($var)) {
    		$var = preg_replace('/\s+/', '', $var);
    		$var = strtolower(preg_replace('/(.)(?=[A-Z])/', '$1'.'_', $var));
		}
		return $var;
	}

	public static function studly($var)
	{
		return str_replace(' ', '', ucwords(str_replace(['-', '_'], ' ', $var)));
	}

}
