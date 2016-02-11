<?php 

namespace Helmut\Forms\Fields\Search;

use Helmut\Forms\Field;
use Helmut\Forms\Utility\Validate;

class Search extends Field {

    public $value = '';

    public function getValue()
    {
        return $this->value;
    }

    public function getButtonName()
    {
        return $this->name.'_button';
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

    public function validateRequired()
    {
        return Validate::required($this->value);
    }

}