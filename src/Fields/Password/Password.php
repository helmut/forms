<?php 

namespace Helmut\Forms\Fields\Password;

use Helmut\Forms\Field;

class Password extends Field {

    public $value = '';

    public function hash($value) 
    {
        if (strlen($value) === 0) {
            return '';
        }

        return password_hash($value, PASSWORD_BCRYPT, ['cost' => 10]);
    }

    public function needsRehash($hash = null)
    {
        if (is_null($hash)) $hash = $this->value;

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

    public function getValues()
    {
        return [$this->name => $this->value];
    }

    public function getProperties()
    {
        return [];
    }

    public function getButtons()
    {
        return [];
    }   

    public function setValuesFromDefaults($defaults)
    {
        //
    }

    public function setValuesFromModel($model)
    {
        if (property_exists($model, $this->name)) $this->value = $model->{$this->name};
    }

    public function setValuesFromRequest($request)
    {
        $this->value = $this->hash($request->get($this->name));
    }

    public function fillModelWithValues($model)
    {
        if (property_exists($model, $this->name)) $model->{$this->name} = $this->value;
    }   

    public function validateRequired()
    {
        return $this->validator()->required($this->value);
    }

}