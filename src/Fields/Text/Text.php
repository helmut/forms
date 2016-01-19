<?php 

namespace Helmut\Forms\Fields\Text;

use Helmut\Forms\Field;
use Helmut\Forms\Utility\Validate;

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
        return Validate::required($this->value);
    }

    public function validateBetween($min, $max)
    {
        return Validate::stringMin($this->value, $min) 
                && Validate::stringMax($this->value, $max);
    }

    public function validateMax($max)
    {
        return Validate::stringMax($this->value, $max);
    }

    public function validateMin($min)
    {
        return Validate::stringMin($this->value, $min);
    }   

    public function validateAlpha()
    {
        return Validate::alpha($this->value);
    }

    public function validateAlphaNum()
    {
        return Validate::alphaNum($this->value);
    }

    public function validateAlphaDash()
    {
        return Validate::alphaDash($this->value);
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