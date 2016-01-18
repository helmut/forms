<?php 

namespace Helmut\Forms\Fields\Text;

use Helmut\Forms\Field;

class Text extends Field {

    public $value = '';
    public $width = '100%';

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

    public function validateRequired()
    {
        return $this->validator()->required($this->value);
    }

    public function validateBetween($min, $max)
    {
        return $this->validator()->stringMin($this->value, $min) 
                && $this->validator()->stringMax($this->value, $max);
    }

    public function validateMax($max)
    {
        return $this->validator()->stringMax($this->value, $max);
    }

    public function validateMin($min)
    {
        return $this->validator()->stringMin($this->value, $min);
    }   

    public function validateAlpha()
    {
        return $this->validator()->alpha($this->value);
    }

    public function validateAlphaNum()
    {
        return $this->validator()->alphaNum($this->value);
    }

    public function validateAlphaDash()
    {
        return $this->validator()->alphaDash($this->value);
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