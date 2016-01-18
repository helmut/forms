<?php 

namespace Helmut\Forms;

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
     * @return void
     */
	public function __construct() 
	{
		$this->setPath();
	}

	/**
     * Set the plugin autoload path.
     *
     * @return void
     */
	public function setPath()
	{
		$reflector = new \ReflectionClass($this);
		$this->path = dirname($reflector->getFileName());;
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
     * Trigger an event callback. 
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
		$name = $form->validator()->studly($name);

		if (method_exists($this, 'on'.$name)) {
			return call_user_func_array(array($this, 'on'.$name), [$form, $params]);
		}

	}

}
