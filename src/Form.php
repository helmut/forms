<?php 

namespace Helmut\Forms;

use Helmut\Forms\Utility\Str;
use Helmut\Forms\Utility\Reflect;

abstract class Form {

    /**
     * The request implementation used by the form.
     *
     * @var \Helmut\Forms\Request
     */
    protected $request;
    
    /**
     * The renderer used by the form.
     *
     * @var \Helmut\Forms\Renderer
     */
    protected $renderer;

    /**
     * The unique id of the form.
     *
     * @var string
     */
    public $id; 

    /**
     * The action for the form.
     *
     * @var string
     */
    public $action = '';    

    /**
     * Array containing all the form fields.
     *
     * @var array
     */
    protected $fields = [];

    /**
     * Array of button keys.
     *
     * @var array
     */
    protected $buttons = [];    

    /**
     * Array of models.
     *
     * @var array
     */
    protected $models = []; 

    /**
     * The active template package.
     *
     * @var string
     */
    protected $template;

    /**
     * The active language used.
     *
     * @var string
     */
    protected $lang = 'en'; 

    /**
     * A cache of language translations.
     *
     * @var array
     */
    protected $translations = [];   

    /**
     * An array of plugins.
     *
     * @var array
     */
    protected $plugins = [];    

    /**
     * An array of namespaces for class loading.
     *
     * @var array
     */
    protected $namespaces = [];

    /**
     * An array of paths for autoloading.
     *
     * @var array
     */
    protected $paths = [];  

    /**
     * The static instantiation counter. Used
     * to make sure each form implementation can
     * have a unique id.
     *
     * @var integer
     */
    protected static $count = 0;
  
    /**
     * Create a new form.
     *
     * @param  \Helmut\Forms\Request  $request
     * @param  \Helmut\Forms\Renderer  $renderer
     */
    public function __construct(Request $request = null, Renderer $renderer = null)
    {
        $this->request = $request ?: new Requests\Globals;
        $this->renderer = $renderer ?: new Renderer;

        $this->loadNamespaces();
    
        $this->setId();
        $this->loadDefaults();
        $this->triggerDefinition();
    }

    /**
     * Load namespaces.
     *
     * @return void
     */
    public function loadNamespaces()
    {
        $class = get_class($this);

        $classes = [$class];

        while ($class = get_parent_class($class)) {
            $classes[] = $class;
        }

        $classes = array_reverse($classes);

        foreach ($classes as $class) {
            $this->addNamespaceForClass($class);
        }
    }

    /**
     * Set a unique id.
     *
     * @return void
     */
    public function setId()
    {
        self::$count++;
        $id = substr(md5(self::$count), 0, 5);
        $this->id = 'form_'.$id;
    }

    /**
     * Load form defaults
     *
     * @return void
     */
    public function loadDefaults()
    {
        if (is_null($this->template)) {
            $this->setTemplate('bootstrap');
        }
    }

    /**
     * Trigger the definition.
     *
     * @return void
     */
    public function triggerDefinition()
    {
        if (method_exists($this, 'define')) {
            call_user_func_array([$this, 'define'], []);
        }

        $this->broadcast('define');
    }    

    /**
     * Add a new field.
     *
     * @param  string  $type
     * @param  string  $name
     * @return \Helmut\Forms\Fields\Field
     */
    public function addField($type, $name)
    {
        if ( ! isset($this->fields[$name])) { 
            $class = $this->typeToClass($type);
            $field = new $class($this, $type, $name);
            foreach ($field->buttons() as $button) {
                $this->addButton($button);
            }
            $this->fields[$name] = $field;
        }
        return $this->fields[$name];
    }

    /**
     * Set all the field values.
     *
     * @return void
     */
    public function setValues()
    {
        foreach ($this->fields as $field)
        {
            // Set values from defaults
            $field->setFromDefaults();

            // Then load values from models
            foreach ($this->models as $model) {
                $field->setFromModel($model);
            }

            // Then from the current request if submitted
            if ($this->submitted()) {
                $field->setFromRequest($this->request);
            }
        }
    }

    /**
     * Add default models to the form.
     *
     * @return void
     */
    public function defaults() 
    {
        $models = func_get_args();
        
        foreach ($models as $model) {
            $this->models[] = (object) $model;
        }

    }

    /**
     * Fetch all fields or just those matching
     * the names provided.
     *
     * @param  array  $names
     * @return array
     */
    public function fields($names = null)
    {
        if (is_null($names)) return $this->fields;

        return array_filter($this->fields, function($field) use ($names) {
            return array_key_exists($field->name, $names);
        });
    }   

    /**
     * Get a field matching name.
     *
     * @param  string  $name
     * @return \Helmut\Forms\Field
     */
    public function field($name)
    {
        if (isset($this->fields[$name])) {
            return $this->fields[$name];
        }
    }   

    /**
     * Fetch all of the field keys.
     *
     * @return array
     */
    public function keys()
    {
        $keys = [];

        foreach ($this->fields as $field) {
            $keys = array_merge($keys, $field->keys());
        }
        
        return $keys;
    }

    /**
     * Fetch all of the field values.
     *
     * @return array
     */
    public function all()
    {
        $this->setValues();

        $values = [];

        foreach ($this->fields as $field) {
            $values = array_merge($values, $field->values());
        }

        return $values;
    }
    
    /**
     * Fetch the value of a field.
     *
     * @param  string  $name
     * @param  string  $key
     * @return array
     */
    public function get($name, $key = null)
    {
        $this->setValues();

        $field = $this->field($name);

        if ( ! is_null($field)) {
            return $field->getValue($key);
        }
    }

    /**
     * Fill a model with values.
     *
     * @param  object  $model
     * @param  array  $names
     */
    public function fill($model, $names = null)
    {
        $this->setValues();

        $fields = $this->fields($names);

        foreach ($fields as $field) {
            $field->fillModel($model);
        }
    }

    /**
     * Check if a form has been submitted and valid in one
     * quick and easy step.
     *
     * @param  string  $name
     * @return bool
     */
    public function completed($name = null)
    {
        if($this->submitted($name) && $this->valid()) {
            $this->broadcast('completed');
            return true;
        }
        return false;
    }

    /**
     * Check if a form has been submitted. If no specific name
     * is requested check for any button.
     *
     * @param  string  $name
     * @return bool
     */
    public function submitted($name = null) 
    {
        $buttons = is_null($name) ? $this->buttons : [$name];

        foreach ($buttons as $button) {
            if ($this->request->get($button) == true) {
                $this->broadcast('submitted');
                return true;
            }
        }

        return false;
    }

    /**
     * Add a button.
     *
     * @param  string  $name
     * @return void
     */
    public function addButton($name)
    {
        $this->buttons[] = $name;
    }

    /**
     * Add a new namespace.
     *
     * @param  string  $namespace
     * @return void
     */
    public function addNamespace($namespace)
    {
        if ( ! in_array($namespace, $this->namespaces)) {
            array_unshift($this->namespaces, $namespace);
        }
    }

    /**
     * Get namespaces.
     *
     * @return array
     */
    public function namespaces()
    {
        return $this->namespaces;
    }

    /**
     * Add a new autoload path.
     *
     * @param  string  $path
     * @return void
     */
    public function addPath($path)
    {
        $path = rtrim($path, '/').'/';

        if ( ! in_array($path, $this->paths) && is_dir($path)) {
            array_unshift($this->paths, $path);
        }
    }

    /**
     * Find and add a new namespace using a class.
     *
     * @param  string  $class
     * @return void
     */
    public function addNamespaceForClass($class)
    {
        $namespace = Reflect::getNamespace($class);

        if ( ! is_null($namespace)) {
            $this->addNamespace($namespace);
        }

        $directory = Reflect::getDirectory($class);
  
        if ( ! is_null($directory) && is_dir($directory)) {
            $this->addPath($directory);
        }
    }   

    /**
     * Check if a type exists.
     *
     * @param  string  $type
     * @return string
     */
    public function typeExists($type)
    {
        return ! is_null($this->typeToClass($type));
    }

    /**
     * Convert a string type to full class name.
     *
     * @param  string  $type
     * @return string
     */
    public function typeToClass($type)
    {
        $class = Str::studly($type);

        $class = '\\Fields\\'.ucwords($class).'\\'.ucwords($class);

        foreach ($this->namespaces as $namespace) {
            if (class_exists($namespace.$class)) return $namespace.$class;
        }
    }

    /**
     * Get the validation errors. With option to
     * get only for a specific field.
     *
     * @param  string  $name
     * @return array     
     */
    public function errors($name = null)
    {
        if ($this->submitted()) $this->validate();

        if ( ! is_null($name)) return $this->field($name)->errors();

        $errors = [];

        foreach ($this->fields as $field) {
            foreach($field->errors() as $error) {
                $errors[] = $error;
            }
        }

        return $errors;
    }

    /**
     * Perform validation on the form. 
     *
     * @return void
     */
    public function validate()
    {
        $this->setValues();

        $this->broadcast('validate');

        foreach ($this->fields as $field) {
            $field->runValidations();
        }

        $this->broadcast('validated');
    }

    /**
     * Perform validation on the form. With option
     * to check if a particular field is valid.
     *
     * @param  string  $name
     * @return bool
     */
    public function valid($name = null)
    {
        $this->validate();

        $fields = is_null($name) ? $this->fields : [$this->field($name)];

        foreach ($fields as $field) {

            if ($field->isInvalid()) {
                $this->broadcast('invalid');
                return false;
            }
        }

        $this->broadcast('valid');
        return true;
    }

    /**
     * The opposite of valid.
     *
     * @param  string  $name
     * @return bool
     */
    public function invalid($name = null)
    {
        return ! $this->valid($name);
    }   

    /**
     * Set the active language.
     *
     * @param  string  $lang
     * @return void
     */
    public function setLanguage($lang)
    {
        $this->lang = $lang;
    }

    /**
     * Set the template package.
     *
     * @param  string  $template
     * @return void
     */
    public function setTemplate($template)
    {
        if ( ! is_null($this->template)) {
            $this->uninstallTemplate($this->template);
        }

        $this->installTemplate($template);
        
        $this->template = $template;
    }

    /**
     * Get template configuration.
     *
     * @param  string  $template
     * @return array
     */
    public function templateConfig($template)
    {
        $paths = $this->paths(null, 'templates/'.$template);

        foreach ($paths as $path) {
            
            $config = $path.'config.php';
            
            if (file_exists($config)) {
                return include($config);
            }
        }

        return [];
    }   

    /**
     * Install template configuration.
     *
     * @param  string  $template
     * @return void
     */
    public function installTemplate($template)
    {
        $config = $this->templateConfig($template);

        if ( isset($config['plugins']) && is_array($config['plugins'])) {
            foreach($config['plugins'] as $plugin) {
                $this->addPlugin($plugin);
            }
        }
    }

    /**
     * Uninstall template configuration.
     *
     * @param  string  $template
     * @return void
     */
    public function uninstallTemplate($template)
    {
        $config = $this->templateConfig($template);

        if ( isset($config['plugins']) && is_array($config['plugins'])) {
            foreach($config['plugins'] as $plugin) {
                $this->removePlugin($plugin);
            }
        }
    }

    /**
     * Fetch a fields properties.
     *
     * @param  \Helmut\Forms\Field  $field
     * @return string
     */
    public function fieldProperties($field) 
    {   
        $properties = [ 
            'id' => $field->id, 
            'form_id' => $this->id, 
            'type' => $field->type, 
            'name' => $field->name, 
            'label' => $field->label,
            'required' => $field->isRequired(),
            'valid' => $field->isValid(),
            'invalid' => $field->isInvalid(),
            'errors' => [],
            'keys' => [],
        ];

        $properties = array_merge($properties, $field->properties());

        foreach ($field->keys() as $key) {
            $properties['keys'][] = $key;
        }

        if ($field->isInvalid()) {
            foreach ($field->errors() as $error => $parameters) {

                if ($error == 'userDefined') {
                    foreach($parameters as $message) {
                        $properties['errors'][] = ['error' => $message];
                    }
                } else {

                    $parameters['field'] = str_replace('_', ' ', $field->name);

                    $message = $this->translate($error, $field);

                    foreach($parameters as $key => $value) {
                        if (is_object($value) && method_exists($value, '__toString')) $value = (string) $value;
                        if (is_array($value)) $value = implode(', ', $value);
                        $message = str_replace('['.$key.']', $value, $message);
                    }
                    $properties['errors'][] = ['error' => $message];
                }
            }
        }

        return $properties;
    }

    /**
     * Render the field using templates.
     *
     * @param  \Helmut\Forms\Field  $field
     * @param  array  $properties
     * @return string
     */
    public function renderField($field, $properties = null) 
    {   
        if (is_null($properties)) $properties = $this->fieldProperties($field);

        return $this->renderTemplate($field->type, $properties, $field);
    }

    /**
     * Render the field using templates.
     *
     * @param  \Helmut\Forms\Field  $field
     * @param  array  $properties
     * @return string
     */
    public function renderFieldErrors($field, $properties = null) 
    {   
        if (is_null($properties)) $properties = $this->fieldProperties($field);

        return $this->renderTemplate('errors', $properties, $field);
    }   

    /**
     * Render the form using templates.
     *
     * @param  string  $template
     * @return string
     */
    public function render($template = null)
    {
        $this->broadcast('render');

        $this->setValues();

        if ($this->submitted()) $this->validate();

        if ( ! is_null($template)) $this->setTemplate($template);

        $properties = [];
        $properties['id'] = $this->id;
        $properties['action'] = $this->action;
        $properties['csrf'] = $this->request->csrf();
        $properties['fields'] = [];     

        $renderered_form = $this->renderTemplate('csrf', $this->request->csrf());

        foreach ($this->fields as $field) {

            $field_properties = $this->fieldProperties($field);

            $properties['fields'][] = $field_properties;

            $rendered_field = $this->renderField($field, $field_properties);
            $rendered_field .= $this->renderFieldErrors($field, $field_properties);

            $field_properties['field'] = $rendered_field;

            $renderered_form .= $this->renderTemplate('field', $field_properties, $field);
        }

        $properties['form'] = $renderered_form;

        $renderered_template = $this->renderTemplate('form', $properties);

        return $renderered_template;
    }

    /**
     * Render a template.
     *
     * @param  string  $template
     * @param  array  $properties
     * @param  \Helmut\Forms\Field  $field
     * @return string
     */
    public function renderTemplate($template, $properties = [], $field = null)
    {
        $paths = $this->templatePaths($field);

        $properties['lang'] = $this->translations($field);

        $rendered_template = $this->renderer->render($template, $properties, $paths);

        $properties[$template] = $rendered_template;

        foreach ($this->plugins as $plugin) {
            if ($this->renderer->has($template, $plugin->templatePaths())) {
                $rendered_template = $this->renderer->render($template, $properties, $plugin->templatePaths());
            }
        }

        return $rendered_template;
    }

    /**
     * Translate a specific key.
     *
     * @param  string  $key
     * @param  \Helmut\Forms\Field  $field
     * @return string
     */
    public function translate($key, $field = null) 
    {
        $translations = $this->translations($field);

        if (isset($translations[$key])) {
            return $translations[$key];
        }

        throw new \Exception('No translation found for '.$key);
    }

    /**
     * Get translations and cache them if necessary.
     *
     * @param  \Helmut\Forms\Field  $field
     * @return array
     */
    public function translations($field = null) 
    {
        $lang = $this->lang;

        if ( ! isset($this->translations[$lang])) {
            $paths = $this->langPaths();
            $this->translations[$lang] = $this->loadTranslations($lang, $paths);
        }

        $translations = $this->translations[$lang];

        if ( ! is_null($field)) {

            if ( ! isset($this->translations[$field->type][$lang])) {

                if ( ! isset($this->translations[$field->type])) {
                    $this->translations[$field->type] = [];
                }

                $paths = $this->langPaths($field);

                $this->translations[$field->type][$lang] = $this->loadTranslations($lang, $paths);
            }

            $translations = array_merge($this->translations[$field->type][$lang], $translations);
        } 

        return $translations;
    }

    /**
     * Load the translations from paths.
     *
     * @param  string  $lang
     * @param  array  $paths
     * @return array
     */
    public function loadTranslations($lang, $paths) 
    {
        $translations = [];

        foreach ($paths as $path) {
            $file = $path.$lang.'.php';
            if (file_exists($file)) {
                $translations = array_merge($translations, include($file));
            }
        }

        return $translations;
    }

    /**
     * Add a plugin to a form.
     *
     * @param  string  $name
     * @return void
     */
    public function addPlugin($name)
    {
        $class = Str::studly($name);

        $class = '\\Plugins\\'.ucwords($class).'\\'.ucwords($class);

        foreach ($this->namespaces as $namespace) {
            
            $plugin = $namespace.$class;
            
            if (class_exists($plugin)) {
                $this->plugins[$name] = new $plugin;
                $this->plugins[$name]->event($this, 'load');

                return;
            }
        }
    }

    /**
     * Remove a plugin.
     *
     * @param  string  $name
     * @return void
     */
    public function removePlugin($name)
    {
        if (array_key_exists($name, $this->plugins)) {
            unset($this->plugins[$name]);
        }
    }

    /**
     * Remove all plugins.
     *
     * @return void
     */
    public function removeAllPlugins()
    {
        foreach ($this->plugins as $name => $plugin) {
            $this->removePlugin($name);
        }
    }   

    /**
     * Broadcast an event.
     *
     * @param  string  $event
     * @param  array  $params
     * @return void
     */
    private function broadcast($event, $params = []) 
    {
        foreach($this->plugins as $plugin) {
            $plugin->event($this, $event, $params);
        }
    }

    /**
     * Get all paths to the language files or just to those
     * for a specific field. 
     *
     * @param  \Helmut\Forms\Field  $field
     * @return array
     */
    public function langPaths($field = null) 
    {
        return $this->paths($field, 'lang');
    }

    /**
     * Get all paths to template packages or just to the 
     * packages for a specific field.
     *
     * @param  \Helmut\Forms\Field  $field
     * @return array
     */
    public function templatePaths($field = null) 
    {
        return $this->paths($field, 'templates/'.$this->template);
    }

    /**
     * Get all autoload paths or just the path 
     * of a specific resource.
     *
     * @param  \Helmut\Forms\Field  $field
     * @param  string  $append
     * @return array
     */
    public function paths($field = null, $append = null) 
    {
        $paths = $this->paths;

        if ( ! is_null($field)) {
            array_unshift($paths, $this->pathForClass($field));
        }

        if ( ! is_null($append)) {
            $paths = array_map(function($path) use($append) {
                return $path .= ltrim(rtrim($append, '/'), '/').'/';
            }, $paths);
        }

        return array_filter($paths, 'is_dir');
    }

    /**
     * Get autoload path for a class.
     *
     * @param  string|object  $class
     * @return string
     */
    public function pathForClass($class)
    {
        $path = Reflect::getDirectory($class);

        return rtrim($path, '/').'/';
    }


    /**
     * Set the form action.
     *
     * @param  string  $action     
     * @return void
     */
    public function setAction($action)
    {
        $this->action = $action;
    }

    /**
     * Get the active template package.
     *
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * Get the request implementation.
     *
     * @return \Helmut\Forms\Request
     */
    public function getRequest()
    {
        return $this->request;
    }   

    /**
     * Get the renderer implementation.
     *
     * @return \Helmut\Forms\Renderer
     */
    public function getRenderer()
    {
        return $this->renderer;
    } 

    /**
     * Get all of the plugins
     *
     * @return array
     */
    public function getPlugins()
    {
        return $this->plugins;
    }   

    /**
     * Requests directly on the object could be trying to
     * create a field so check if type exists.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        if ( ! method_exists($this, $method))
        {
            if ( $this->typeExists($method)) {
                return $this->addField($method, array_shift($parameters));
            }
        }
    }

    /**
     * Render the form.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }   

}
