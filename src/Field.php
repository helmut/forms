<?php 

namespace Helmut\Forms;

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
     * An array of default values.
     *
     * @var array
     */
    protected $defaults = [];

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
     * Return an array of values by key.
     *
     * @return array
     */
    abstract public function getValues();

    /**
     * Provide keys for any buttons.
     *
     * @return array
     */    
    abstract public function getButtons();

    /**
     * Return array of properties for renderering.
     *
     * @return array
     */
    abstract public function getProperties();

    /**
     * Set field values using provided defaults.
     *
     * @param array  $defaults
     * @return void
     */
    abstract public function setValuesFromDefaults($defaults);

    /**
     * Set values using a model.
     *
     * @param object  $model
     * @return void
     */    
    abstract public function setValuesFromModel($model);

    /**
     * Set values from the request.
     *
     * @param \Helmut\Forms\Request  $request
     * @return void
     */    
    abstract public function setValuesFromRequest($request);

    /**
     * Fill a model with field values.
     *
     * @param object  $model
     * @return void
     */    
    abstract public function fillModelWithValues($model);

    /**
     * Return if field passes required validation.
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
        return $this->getValues();
    }

    /**
     * Return an array of properties.
     *
     * @return array
     */    
    public function properties() 
    {
        return $this->getProperties();
    }

    /**
     * Return an array of button keys.
     *
     * @return array
     */    
    public function buttons()
    {
        return $this->getButtons();
    }

    /**
     * Set the field values using defaults.
     *
     * @return void
     */ 
    public function setFromDefaults()
    {
        $this->setValuesFromDefaults($this->defaults);
    }

    /**
     * Set the field values using request.
     *
     * @param \Helmut\Forms\Request  $request
     * @return void
     */ 
    public function setFromRequest($request)
    {
        $this->setValuesFromRequest($request);
    }

    /**
     * Set the field values using a model.
     *
     * @param object  $model
     * @return void
     */     
    public function setFromModel($model)
    {
        $this->setValuesFromModel($model);
    }

    /**
     * Fill a model with field values;
     *
     * @param object  $model
     * @return void
     */     
    public function fillModel($model)
    {
        $this->fillModelWithValues($model);
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
     * Set default values.
     *
     * @param array  $values
     * @return $this
     */
    public function setDefault($values = []) 
    {
        $this->defaults = (array) $values;

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

            $validations = $this->validations;          

            if (method_exists($this, 'validate')) {
                $validations = array_merge(['validate' => []], $validations);
            }

            foreach ($validations as $validation => $parameters) {
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
        $method = $this->validator()->snake($validation);
        
        if ( ! call_user_func_array([$this, $validation], $parameters)) {   
            $this->errors[$method] = $parameters;
            return false;
        }

        if (isset($this->errors[$method])) unset($this->errors[$method]);

        return true;
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
        if ( ! isset($this->errors['userDefined'])) $this->errors['userDefined'] = [];

        $this->errors['userDefined'][] = $message;
    }

    /**
     * Get the value of a field.
     *
     * @param  string  $key
     * @return mixed
     */
    public function getValue($key = null) 
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
     * Get the validator instance.
     *
     * @return \Helmut\Forms\Validator
     */
    public function validator() 
    {
        return $this->form->validator();
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

            $method = $this->validator()->studly($method);

            $name = 'set'.$method;
            if (method_exists($this, $name)) {
                return call_user_func_array([$this, $name], $parameters);
            }

            $name = 'validate'.$method;
            if (method_exists($this, $name)) {

                $args = [];

                // Work out the argument names of the requested method
                $method = new \ReflectionMethod($this, $name);
                foreach($method->getParameters() as $arg) {
                    $args[] = $arg->getName();
                }

                $parameters = array_pad($parameters, count($args), null);

                $this->validations[$name] = array_combine($args, $parameters);

                return $this;
            }           
        }
    }

}