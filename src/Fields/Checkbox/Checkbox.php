<?php 

namespace Helmut\Forms\Fields\Checkbox;

use Helmut\Forms\Field;

class Checkbox extends Field {

    protected $value = false;

    public function getValue() 
    {
        return $this->value;
    }

    public function getButtonName()
    {
        //
    }    

    public function renderWith() 
    {
        return ['checked' => $this->value];
    }       

    public function setChecked()
    {
         $this->default = true;
         return $this;
    }

    public function setUnchecked()
    {
         $this->default = false;
         return $this;
    }   

    public function setValueFromDefault()
    {
        $this->value = $this->default;
    }

    public function setValueFromModel($model)
    {
        if (property_exists($model, $this->name)) $this->value = $model->{$this->name} ? true : false;
    }   

    public function setValueFromRequest($request)
    {
        $this->value = $request->get($this->name) ? true : false;
    }

    public function fillModelWithValue($model)
    {
        if (property_exists($model, $this->name)) $model->{$this->name} = $this->value ? 1 : 0;
    }

    public function validate()
    {
        return true;
    }

    public function validateRequired()
    {
        return $this->value === true;
    }

}
