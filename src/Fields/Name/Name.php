<?php 

namespace Helmut\Forms\Fields\Name;

use Helmut\Forms\Field;

class Name extends Field {

    public $value_first = '';
    public $value_surname = '';
    public $value = '';

    public function getValues() 
    {
        $values = [];
        $values[$this->name.'_first'] = $this->value_first;
        $values[$this->name.'_surname'] = $this->value_surname;
        $values[$this->name] = $this->value;
        return $values;
    }

    public function getButtons()
    {
        return [];
    }

    public function getProperties() 
    {
        return [    'name_first' => $this->name.'_first', 
                    'name_surname' => $this->name.'_surname', 
                    'value_first' => $this->value_first, 
                    'value_surname' => $this->value_surname,
        ];
    }    

    public function setValuesFromDefaults($defaults)
    {
        if (isset($defaults['first'])) $this->value_first = $defaults['first'];
        if (isset($defaults['surname'])) $this->value_surname = $defaults['surname'];
        $this->value = trim($this->value_first.' '.$this->value_surname);
    }

    public function setValuesFromModel($model)
    {
        if (property_exists($model, $this->name.'_first')) $this->value_first = $model->{$this->name.'_first'};
        if (property_exists($model, $this->name.'_surname')) $this->value_surname = $model->{$this->name.'_surname'};
        $this->value = trim($this->value_first.' '.$this->value_surname);
    }

    public function setValuesFromRequest($request)
    {
        $this->value_first = $request->get($this->name.'_first');
        $this->value_surname = $request->get($this->name.'_surname');
        $this->value = trim($this->value_first.' '.$this->value_surname);
    }

    public function fillModelWithValues($model)
    {
        if (property_exists($model, $this->name.'_first')) $model->{$this->name.'_first'} = $this->value_first;
        if (property_exists($model, $this->name.'_surname')) $model->{$this->name.'_surname'} = $this->value_surname;
        if (property_exists($model, $this->name)) $model->{$this->name} = $this->value;
    }

    public function validateRequired()
    {
        return $this->validator()->required($this->value_first)
                && $this->validator()->required($this->value_surname);
    }   

}
