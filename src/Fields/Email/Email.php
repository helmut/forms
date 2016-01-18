<?php 

namespace Helmut\Forms\Fields\Email;

use Helmut\Forms\Field;

class Email extends Field {

    public $value = '';

    public function getValues()
    {
        return [$this->name => $this->value];
    }
    
    public function getButtons()
    {
        return [];
    }

    public function getProperties()
    {
        return ['value' => $this->value];
    }    

    public function setValuesFromDefaults($defaults)
    {
        if (count($defaults)) $this->value = array_shift($defaults);
    }

    public function setValuesFromModel($model)
    {
        if (property_exists($model, $this->name)) $this->value = $model->{$this->name};
    }   

    public function setValuesFromRequest($request)
    {
        $this->value = $request->get($this->name);
    }

    public function fillModelWithValues($model)
    {
        if (property_exists($model, $this->name)) $model->{$this->name} = $this->value;
    }   

    public function validate()
    {
        return $this->validateEmail();
    }

    public function validateEmail()
    {
        return $this->validator()->email($this->value);
    }

    public function validateRequired()
    {
        return $this->validator()->required($this->value);
    }

}
