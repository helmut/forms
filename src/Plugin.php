<?php 

namespace Helmut\Forms;

use Helmut\Forms\Utility\Str;
use Helmut\Forms\Utility\Reflect;

abstract class Plugin {
	
    /**
     * Autoload path for plugin.
     *
     * @var string
     */
	protected $path;

    /**
     * Create a new plugin instance.
     *
     * @param  array  $config
     * @return void
     */
	public function __construct($config = null) 
	{
        $this->configure($config);

		$this->setPath();
	}

    /**
     * Configure the plugin.
     *
     * @param  array  $config
     * @return void
     */   
    public function configure($config)
    {
        foreach ((array) $config as $key => $value) {
            $method = 'set'.Str::studly($key);
            if (method_exists($this, $method)) {
                $this->{$method}($value);
            }
        }        
    }

	/**
     * Set the plugin autoload path.
     *
     * @return void
     */
	public function setPath()
	{
        $this->path = Reflect::getDirectory($this);
	}

	/**
     * Get autoload path.
     *
     * @return string
     */
	public function path($append = null) 
	{
		return is_null($append) ? $this->path 
			: $this->path.'/'.ltrim(rtrim($append, '/'), '/').'/';
	}

	/**
     * Get paths to templates.
     *
     * @return string
     */
	public function templatePaths() 
	{
		$path = $this->path('templates');
		return [$path];
	}

	/**
     * Trigger an event callback. This allows
     * you to hook into events from within the plugin.
     * - onLoad
     * - onDefine
     * - onRender
     * - onSubmitted
     * - onCompleted
     * - onValidate
     * - onValidated
     * - onValid
     * - onInvalid
     *
	 * @param  \Helmut\Forms\Form  $form
	 * @param  string  $name
	 * @param  array  $params
     * @return mixed
     */
	public function event($form, $name, $params = []) 
	{
		$name = Str::studly($name);

		if (method_exists($this, 'on'.$name)) {
			return call_user_func_array(array($this, 'on'.$name), [$form, $params]);
		}

	}

}
