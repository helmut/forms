<?php 

namespace Helmut\Forms\Fields\Email;

use Helmut\Forms\Field;
use Helmut\Forms\Utility\Validate;

class Email extends Field {

    protected $value = '';

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
        return ['value' => $this->value];
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
        return $this->email();
    }

    public function validateEmail()
    {
        return Validate::email($this->value);
    }

    public function validateRequired()
    {
        return Validate::required($this->value);
    }

}
