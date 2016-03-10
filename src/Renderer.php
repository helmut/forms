<?php 

namespace Helmut\Forms;

class Renderer {

    /**
     * Array of engine definitions using
     * file extension as key.
     * 
     * @var array
     */
    protected $engines = [
        '.mustache.php' => 'Helmut\Forms\Engines\Mustache',
        '.twig.php' => 'Helmut\Forms\Engines\Twig',
        '.blade.php' => 'Helmut\Forms\Engines\Blade',
    ];

    /**
     * Cache of running engines.
     *
     * @var array
     */
    protected $running = [];

    /**
     * Cache of template files.
     *
     * @var array
     */
    protected $templates = [];

    /**
     * Add a new engine implementation.
     *
     * @param  string  $extension
     * @param  string  $class
     * @return void
     */
    public function addEngine($extension, $class)
    {
        array_unshift($this->engines, [$extension => $class]);
    }

    /**
     * Get an engine implementation.
     *
     * @param  string  $key
     * @return \Helmut\Forms\Engine
     */
    public function start($key)
    {
        if ( ! isset($this->running[$key])) {
            $this->running[$key] = new $this->engines[$key];
        }

        return $this->running[$key];
    }

    /**
     * Get engine file extensions.
     *
     * @return array
     */
    public function extensions()
    {
        return array_keys($this->engines);
    }

    /**
     * Create a template cache key.
     *
     * @param  string  $template
     * @param  array  $paths
     * @return string
     */ 
    public function key($template, $paths) 
    {
        return $template.'-'.md5(serialize($paths));
    }

    /**
     * Render a template.
     *
     * @param  string  $template
     * @param  array  $properties
     * @param  array  $paths
     * @return string
     */
    public function render($template, $properties, $paths)
    {
        if ($this->has($template, $paths)) {

            $template = $this->findTemplate($template, $paths);

            return $this->start($template['engine'])->render($template['path'], $properties);
        }
    }

    /**
     * Check if a template exists.
     *
     * @param  string  $template
     * @param  array  $paths
     * @return boolean
     */ 
    public function has($template, $paths)
    {
        return ! is_null($this->findTemplate($template, $paths));
    }

    /**
     * Find template file with engine.
     *
     * @param  string  $template
     * @param  array  $paths
     * @return array
     */ 
    public function findTemplate($template, $paths)
    {
        $key = $this->key($template, $paths);

        if ( ! isset($this->templates[$key])) {

            $this->templates[$key] = null;

            $extensions = $this->extensions();
            foreach ($paths as $path) {
                foreach ($extensions as $extension) {
                    if (file_exists($path.$template.$extension)) {
                        return $this->templates[$key] = [
                            'engine' => $extension, 
                            'path' => $path.$template.$extension,
                        ];
                    }
                }
            }
        }

        return $this->templates[$key];
    }   

}
