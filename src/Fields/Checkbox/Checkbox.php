<?php 

namespace Helmut\Forms\Fields\Checkbox;

use Helmut\Forms\Field;

class Checkbox extends Field {

    public $value = false;

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
        return ['checked' => $this->value];
    }       

    public function setChecked()
    {
         $this->defaults = [true];
         return $this;
    }

    public function setUnchecked()
    {
         $this->defaults = [false];
         return $this;
    }   

    public function setValuesFromDefaults($defaults)
    {
        $this->value = current($defaults) ? true : false;
    }

    public function setValuesFromModel($model)
    {
        if (property_exists($model, $this->name)) $this->value = $model->{$this->name} ? true : false;
    }   

    public function setValuesFromRequest($request)
    {
        $this->value = $request->get($this->name) ? true : false;
    }

    public function fillModelWithValues($model)
    {
        if (property_exists($model, $this->name)) $model->{$this->name} = $this->value ? 1 : 0;
    }

    public function validateRequired()
    {
        return $this->value === true;
    }

}
