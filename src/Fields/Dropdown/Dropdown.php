<?php 

namespace Helmut\Forms\Fields\Dropdown;

use Helmut\Forms\Field;
use Helmut\Forms\Utility\Validate;

class Dropdown extends Field {

    public $options = [];
    
    public $value = '';

    public function setOptions($options)
    {
        $this->options = $options;
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
        $options = [];
        foreach ($this->options as $value => $label) {
            $options[] = ['value'=>$value, 'label'=>$label, 'selected' => $this->value == $value];
        }
        return ['value' => $this->value, 'options' => $options];
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

}
