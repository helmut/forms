<?php 

namespace Helmut\Forms\Fields\Number;

use Helmut\Forms\Field;
use Helmut\Forms\Utility\Validate;

class Number extends Field {

    protected $value = '';
    protected $width = '30%';

    public function setWidth($width)
    {
        $this->width = $width;
        return $this;
    }

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
        return [
            'value' => $this->value, 
            'width' => $this->width,
        ];
    }

    public function setValueFromDefault()
    {
        $this->value = $this->default;
    }

    public function setValueFromModel($model)
    {
        if (isset($model->{$this->name})) $this->value = $model->{$this->name};
    }

    public function setValueFromRequest($request)
    {
        $this->value = $request->get($this->name);
    }

    public function fillModelWithValue($model)
    {
        $model->{$this->name} = $this->value;
    }   

    public function validate()
    {
        $this->numeric();
    }

    public function validateNumeric()
    {
        return Validate::numeric($this->value);
    }

    public function validateRequired()
    {
        return Validate::required($this->value);
    }

    public function validateBetween($min, $max)
    {
        return Validate::numericMin($this->value, $min) 
                && Validate::numericMax($this->value, $max);
    }

    public function validateMax($max)
    {
        return Validate::numericMax($this->value, $max);
    }

    public function validateMin($min)
    {
        return Validate::numericMin($this->value, $min);
    }

    public function validateInteger()
    {
        return Validate::integer($this->value);
    }

    public function validateIn($values = [])
    {
        return Validate::in($this->value, $values);
    }

    public function validateNotIn($values = [])
    {
        return Validate::notIn($this->value, $values);
    }
    
}