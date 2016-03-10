<?php 

namespace Helmut\Forms\Engines;

use Helmut\Forms\Engine;
use Mustache_Engine;

class Mustache implements Engine {

    /**
     * The mustache compiler engine.
     *
     * @var \Mustache_Engine
     */ 
    protected $compiler;

    /**
     * Fetch the compiler.
     *
     * @return \Mustache_Engine
     */
    public function compiler()
    {
        if ( ! $this->compiler) $this->compiler = new Mustache_Engine;

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

        return $this->compiler()->render($content, $properties);
    }

}
