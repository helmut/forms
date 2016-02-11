<?php 

namespace Helmut\Forms\Fields\ParagraphText;

use Helmut\Forms\Field;
use Helmut\Forms\Utility\Validate;

class ParagraphText extends Field {

    public $value = '';

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