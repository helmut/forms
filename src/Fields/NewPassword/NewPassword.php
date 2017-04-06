<?php 

namespace Helmut\Forms\Fields\NewPassword;

use Helmut\Forms\Field;
use Helmut\Forms\Utility\Validate;

class NewPassword extends Field {

    protected $value = '';
    protected $value_confirmation = '';

    public function hash($value) 
    {
        if (strlen($value) === 0) {
            return '';
        }

        return password_hash($value, PASSWORD_BCRYPT, ['cost' => 10]);
    }

    public function getValue()
    {
        return $this->hash($this->value);
    }

    public function getButtonName()
    {
        //
    }

    public function renderWith()
    {
        return [    
            'name' => $this->name, 
            'name_confirmation' => $this->name.'_confirmation', 
            'value' => $this->value,
            'value_confirmation' => $this->value_confirmation,
        ];
    }

    public function setValueFromDefault()
    {
        //
    }

    public function setValueFromModel($model)
    {
        //
    }

    public function setValueFromRequest($request)
    {
        $this->value = $request->get($this->name);
        $this->value_confirmation = $request->get($this->name.'_confirmation');
    }

    public function fillModelWithValue($model)
    {
        if (property_exists($model, $this->name)) {
            $model->{$this->name} = $this->hash($this->value);
        }
    }

    public function validate()
    {
        $this->matches();
    }

    public function validateMatches()
    {
        return Validate::matches($this->value, $this->value_confirmation);
    }    
    
    public function validateRequired()
    {
        return Validate::required($this->value);
    }

}