<?php 

namespace Helmut\Forms\Fields\Button;

use Helmut\Forms\Field;

class Button extends Field {

    public function getValue() 
    {
        // 
    }

    public function getButtonName() 
    {
        return $this->name;
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
        //
    }   

    public function setValueFromRequest($request)
    {
        //
    }

    public function fillModelWithValue($model)
    {
        //
    }

    public function validateRequired()
    {
        return true;
    }

}