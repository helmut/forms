<?php 

namespace Helmut\Forms\Fields\Name;

use Helmut\Forms\Field;
use Helmut\Forms\Utility\Validate;

class Name extends Field {

    protected $default = [];
    protected $value_first = '';
    protected $value_surname = '';
    protected $value = '';

    public function getValue() 
    {
        $values = [];
        $values[$this->name.'_first'] = $this->value_first;
        $values[$this->name.'_surname'] = $this->value_surname;
        $values[$this->name] = $this->value;
        return $values;
    }

    public function getButtonName()
    {
        //
    }

    public function renderWith() 
    {
        return [    
            'name_first' => $this->name.'_first', 
            'name_surname' => $this->name.'_surname', 
            'value_first' => $this->value_first, 
            'value_surname' => $this->value_surname,
        ];
    }    

    public function setValueFromDefault()
    {
        if (isset($this->default['first'])) $this->value_first = $this->default['first'];
        if (isset($this->default['surname'])) $this->value_surname = $this->default['surname'];
        $this->value = trim($this->value_first.' '.$this->value_surname);
    }

    public function setValueFromModel($model)
    {
        if (property_exists($model, $this->name.'_first')) $this->value_first = $model->{$this->name.'_first'};
        if (property_exists($model, $this->name.'_surname')) $this->value_surname = $model->{$this->name.'_surname'};
        $this->value = trim($this->value_first.' '.$this->value_surname);
    }

    public function setValueFromRequest($request)
    {
        $this->value_first = $request->get($this->name.'_first');
        $this->value_surname = $request->get($this->name.'_surname');
        $this->value = trim($this->value_first.' '.$this->value_surname);
    }

    public function fillModelWithValue($model)
    {
        if (property_exists($model, $this->name.'_first')) $model->{$this->name.'_first'} = $this->value_first;
        if (property_exists($model, $this->name.'_surname')) $model->{$this->name.'_surname'} = $this->value_surname;
        if (property_exists($model, $this->name)) $model->{$this->name} = $this->value;
    }

    public function validate()
    {
        return true;
    } 

    public function validateRequired()
    {
        return Validate::required($this->value_first)
                && Validate::required($this->value_surname);
    }   

}
