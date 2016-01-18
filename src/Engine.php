<?php 

namespace Helmut\Forms;

interface Engine {
	
	/**
     * Render the template content.
     *
	 * @param  string  $path
	 * @param  array  $properties
     * @return string
     */
	public function render($path, $properties = []);

}