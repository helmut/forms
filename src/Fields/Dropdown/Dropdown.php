<?php 

namespace Helmut\Forms\Fields\Dropdown;

use Helmut\Forms\Field;
use Helmut\Forms\Utility\Validate;

class Dropdown extends Field {

    protected $options = [];
    protected $value = '';

    public function setOptions($options)
    {
        $this->options = $options;
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
        $properties = [
            'value' => $this->value, 
            'options' => [],
        ];

        foreach ($this->options as $value => $label) {
            $properties['options'][] = [
                'value' => $value, 
                'label' => $label, 
                'selected' => $this->value == $value
            ];
        }

        return $properties;
    }

    public function setValueFromDefault()
    {
        $this->value = $this->default;
    }

    public function setValueFromModel($model)
    {
        if (property_exists($model, $this->name)) $this->value = $model->{$this->name};
    }   

    public function setValueFromRequest($request)
    {
        $this->value = $request->get($this->name);
    }

    public function fillModelWithValue($model)
    {
        if (property_exists($model, $this->name)) $model->{$this->name} = $this->value;
    }   

    public function validate()
    {
        return true;
    }
    
    public function validateRequired()
    {
        return Validate::required($this->value);
    }

}
