<?php 

namespace Helmut\Forms;

use Helmut\Forms\Utility\Str;
use Helmut\Forms\Utility\Reflect;

abstract class Field {

    /**
     * The parent form.
     *
     * @var \Helmut\Forms\Form
     */
    protected $form;

    /**
     * The type of the field.
     *
     * @var string
     */
    public $type;

    /**
     * The name of the field.
     *
     * @var string
     */
    public $name;

    /**
     * The unique id of the field.
     *
     * @var string
     */
    public $id;     

    /**
     * The label property of the field.
     *
     * @var string
     */
    public $label;

    /**
     * The default value of the field.
     *
     * @var mixed
     */
    protected $default;

    /**
     * Field is required.
     *
     * @var boolean
     */
    protected $required = false;

    /**
     * An array of validation methods.
     *
     * @var array
     */
    protected $validations = [];

    /**
     * An array of validation errors.
     *
     * @var array
     */
    protected $errors = [];

    /**
     * Create a field instance.
     *
     * @param  \Helmut\Forms\Form  $form
     * @param  string  $type
     * @param  string  $name
     */
    public function __construct(\Helmut\Forms\Form $form, $type, $name)
    {
        $this->form = $form;
        $this->type = $type;
        $this->name = $name;

        $this->setId();
    }

    /**
     * Return an the value of the field. For fields 
     * with multiple values return an array of values
     * using associative key names.
     *
     * @return array
     */
    abstract public function getValue();

    /**
     * Provide the key names of any buttons. Multiple
     * buttons may be returned using an array.
     *
     * @return mixed
     */    
    abstract public function getButtonName();

    /**
     * Return array of properties for renderering.
     *
     * @return array
     */
    abstract public function renderWith();

    /**
     * Set field value using provided default.
     *
     * @return void
     */
    abstract public function setValueFromDefault();

    /**
     * Set value using a model.
     *
     * @param object  $model
     * @return void
     */    
    abstract public function setValueFromModel($model);

    /**
     * Set value from the request.
     *
     * @param \Helmut\Forms\Request  $request
     * @return void
     */    
    abstract public function setValueFromRequest($request);

    /**
     * Fill a model with field values.
     *
     * @param object  $model
     * @return void
     */    
    abstract public function fillModelWithValue($model);

    /**
     * Return if field validates required.
     *
     * @return boolean
     */    
    abstract public function validateRequired();

    /**
     * Set a unique id.
     *
     * @return void
     */
    public function setId()
    {
        $id = $this->type.'_'.substr(md5($this->name), 0, 5);
        $this->id = $this->form->id.'_'.$id;
    }

    /**
     * Return an array of keys.
     *
     * @return array
     */
    public function keys()
    {
        return array_keys($this->values());
    }

    /**
     * Return an array of values.
     *
     * @return array
     */
    public function values() 
    {
        $values = $this->getValue();

        if (is_null($values)) {
            return [];
        } 

        if ( ! is_array($values)) {
            return [$this->name => $values];
        }

        return $values;
    }

    /**
     * Return an array of properties to be passed
     * to the template during rendering.
     *
     * @return array
     */    
    public function properties() 
    {
        $properties = $this->renderWith();

        if (is_null($properties)) {
            return [];
        }

        return $properties;
    }

    /**
     * Return an array of button keys.
     *
     * @return array
     */    
    public function buttons()
    {
        $buttons = $this->getButtonName();

        if (is_null($buttons)) {
            return [];
        }

        if ( ! is_array($buttons)) {
            return [$buttons];
        }

        return $buttons;
    }

    /**
     * Set the field value using default.
     *
     * @return void
     */ 
    public function setFromDefault()
    {
        if ( ! is_null($this->default)) {
            $this->setValueFromDefault();
        }
    }

    /**
     * Set the field value using request.
     *
     * @param \Helmut\Forms\Request  $request
     * @return void
     */ 
    public function setFromRequest($request)
    {
        $this->setValueFromRequest($request);
    }

    /**
     * Set the field values using a model.
     *
     * @param object  $model
     * @return void
     */     
    public function setFromModel($model)
    {
        $this->setValueFromModel($model);
    }

    /**
     * Fill a model with field value;
     *
     * @param object  $model
     * @return void
     */     
    public function fillModel($model)
    {
        $this->fillModelWithValue($model);
    }

    /**
     * Return the name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }    

    /**
     * Set the label property.
     *
     * @param string  $label
     * @return $this
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Set required status.
     *
     * @param boolean  $status
     * @return $this
     */
    public function setRequired($status = true)
    {
        $this->required = $status;

        return $this;
    } 

    /**
     * Set the default value.
     *
     * @param mixed  $value
     * @return $this
     */
    public function setDefault($value) 
    {
        $this->default = $value;

        return $this;
    }

    /**
     * Check if valid.
     *
     * @return boolean
     */
    public function isValid() 
    {
        return count($this->errors) == 0;
    }

    /**
     * Check if invalid.
     *
     * @return boolean
     */
    public function isInvalid() 
    {
        return ! $this->isValid();
    }

    /**
     * Add a validation.
     *
     * @param string  $method     
     * @param array  $parameters     
     * @return void
     */
    protected function addValidation($method, $parameters) 
    {
        $this->validations[$method] = $parameters;
    }    

    /**
     * Perform all validations.
     *
     * @return void
     */
    public function runValidations() 
    {
        if ($this->required) {
            $this->callValidationMethod('validateRequired');
        }

        if ($this->isNotEmpty()) {

            if (method_exists($this, 'validate')) {
                $this->validate();
            }

            foreach ($this->validations as $validation => $parameters) {
                $this->callValidationMethod($validation, $parameters);
            }
        }

    }

    /**
     * Call a validation method.
     *
     * @return boolean
     */
    public function callValidationMethod($validation, $parameters = []) 
    {
        $method = Str::snake($validation);

        $validated = call_user_func_array([$this, $validation], $parameters);

        if ($validated) {
            $this->clearValidationError($method);
            return true;
        }

        $this->addValidationError($method, $parameters);
        return false;
    }    

    /**
     * Check if field is required.
     *
     * @return boolean
     */
    public function isRequired() 
    {
        return $this->required;
    }     

    /**
     * Check if field has been filled.
     *
     * @return boolean
     */
    public function isNotEmpty() 
    {
        return $this->validateRequired();
    }   

    /**
     * Return validation errors.
     *
     * @return array
     */
    public function errors() 
    {
        return $this->errors;
    }

    /**
     * Add a user defined validation error.
     *
     * @return array
     */
    public function error($message)
    {
        if ( ! isset($this->errors['userDefined'])) {
            $this->errors['userDefined'] = [];
        }

        $this->errors['userDefined'][] = $message;
    }

    /**
     * Add an internal validation error.
     *
     * @param string  $method     
     * @param array  $parameters     
     * @return void
     */
    protected function addValidationError($method, $parameters) 
    {
        $this->errors[$method] = $parameters;
    }

    /**
     * Remove all internal validation errors for a method.
     *
     * @param string  $method     
     * @return void
     */
    protected function clearValidationError($method) 
    {
        if (isset($this->errors[$method])) {
            unset($this->errors[$method]);
        }
    }    

    /**
     * Get the value of a field.
     *
     * @param  string  $key
     * @return mixed
     */
    public function value($key = null) 
    {
        $values = $this->values();

        if (is_null($key)) {
            
            if (count($values) == 1) {
                $values = current($values);
            }

            return $values;
        }
        
        $key = $this->name.'_'.$key;

        if (array_key_exists($key, $values)) {
            return $values[$key];
        }
    }

    /**
     * Translate a specific key.
     *
     * @param  string  $key
     * @return string
     */
    public function translate($key) 
    {
        return $this->form->translate($key, $this);
    }

    /**
     * Get the parent form.
     *
     * @return \Helmut\Forms\Form
     */
    public function getForm()
    {
        return $this->form;
    }   

    /**
     * Gives this class the ability to set and get any of the
     * properties of the instances that inherit from this class
     * using shorthand notation. Call label() instead of
     * setLabel() for example.
     *
     * Also it allows you to specify validations in the same dynamic
     * manner like required() or between(1, 10).
     *
     * @param string  $method
     * @param array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        if ( ! method_exists($this, $method)) {

            $method = Str::studly($method);

            $name = 'set'.$method;
            if (method_exists($this, $name)) {
                return call_user_func_array([$this, $name], $parameters);
            }

            $name = 'validate'.$method;
            if (method_exists($this, $name)) {
                $arguments = Reflect::getParameters($this, $name);
                $parameters = array_pad($parameters, count($arguments), null);
                $this->addValidation($name, array_combine($arguments, $parameters));
                return $this;
            }           
        }
    }

}