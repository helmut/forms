<?php 

namespace Helmut\Forms\Fields\Number;

use Helmut\Forms\Field;

class Number extends Field {

    public $value = '';
    public $width = '30%';

    public function setWidth($width)
    {
        $this->width = $width;
        return $this;
    }

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
        return ['value' => $this->value, 'width' => $this->width];
    }

    public function setValuesFromDefaults($defaults)
    {
        if (count($this->defaults)) $this->value = array_shift($this->defaults);
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
        return $this->validateNumeric();
    }

    public function validateNumeric()
    {
        return $this->validator()->numeric($this->value);
    }

    public function validateRequired()
    {
        return $this->validator()->required($this->value);
    }

    public function validateBetween($min, $max)
    {
        return $this->validator()->numericMin($this->value, $min) 
                && $this->validator()->numericMax($this->value, $max);
    }

    public function validateMax($max)
    {
        return $this->validator()->numericMax($this->value, $max);
    }

    public function validateMin($min)
    {
        return $this->validator()->numericMin($this->value, $min);
    }

    public function validateInteger()
    {
        return $this->validator()->integer($this->value);
    }

    public function validateIn($values = [])
    {
        return $this->validator()->in($this->value, $values);
    }

    public function validateNotIn($values = [])
    {
        return $this->validator()->notIn($this->value, $values);
    }
    
}