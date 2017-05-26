<?php 

namespace Helmut\Forms\Fields\Password;

use Helmut\Forms\Field;
use Helmut\Forms\Utility\Validate;

class Password extends Field {

    protected $value = '';

    public function hash($value) 
    {
        if (strlen($value) === 0) {
            return '';
        }

        return password_hash($value, PASSWORD_BCRYPT, ['cost' => 10]);
    }

    public function needsRehash($hash = null)
    {
        if (is_null($hash)) {
            $hash = $this->value;
        }

        return password_needs_rehash($hash, PASSWORD_BCRYPT, ['cost' => 10]);
    }   

    public function matches($hash)
    {
        if (strlen($hash) === 0) {
            return false;
        }

        $check = $this->form->getRequest()->get($this->name);

        return password_verify($check, $hash);
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
        //
    }

    public function setValueFromDefault()
    {
        //
    }

    public function setValueFromModel($model)
    {
        if (isset($model->{$this->name})) {
            $this->value = $model->{$this->name};
        }
    }

    public function setValueFromRequest($request)
    {
        $this->value = $this->hash($request->get($this->name));
    }

    public function fillModelWithValue($model)
    {
        if (isset($model->{$this->name})) {
            $model->{$this->name} = $this->value;
        }
    }   
    
    public function validateRequired()
    {
        return Validate::required($this->value);
    }

}