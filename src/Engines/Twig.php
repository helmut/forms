<?php 

namespace Helmut\Forms\Engines;

use Helmut\Forms\Engine;
use Twig_Environment;
use Twig_Loader_Array;

class Twig implements Engine {

  	/**
     * The twig compiler engine.
     *
     * @var \Twig_Environment
     */	
	protected $compiler;

	/**
     * Fetch the compiler.
     *
     * @return \Twig_Environment
     */
	public function compiler()
	{
		if ( ! $this->compiler) {
			$this->compiler = new Twig_Environment(new Twig_Loader_Array([]));
		}

		return $this->compiler;
	}

	/**
     * Render the template content.
     *
	 * @param  string  $path
	 * @param  array  $properties
     * @return string
     */
	public function render($path, $properties = []) 
	{
		$content = file_get_contents($path);

        $template = $this->compiler()->createTemplate($content);

		return $template->render($properties);
	}

}
