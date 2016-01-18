<?php 

namespace Helmut\Forms\Engines;

use Helmut\Forms\Engine;

class Blade implements Engine {

	/**
     * Render the template content.
     *
	 * @param  string  $path
	 * @param  array  $properties
     * @return string
     */
	public function render($path, $properties = []) 
	{
		if ( ! function_exists('app')) throw new \Exception('Laravel required for blade rendering engine.');

		return app()->make('view')->file($path, $properties);
	}

}
