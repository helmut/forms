<?php 

namespace Helmut\Forms\Fields\Button;

use Helmut\Forms\Field;

class Button extends Field {

    public function getValues() 
    {
        return [];
    }

    public function getButtons() 
    {
        return [$this->name];
    }

    public function getProperties() 
    {
        return [];
    }

    public function setValuesFromDefaults($defaults)
    {
        // 
    }

    public function setValuesFromModel($model)
    {
        //
    }   

    public function setValuesFromRequest($request)
    {
        //
    }

    public function fillModelWithValues($model)
    {
        //
    }   

    public function validateRequired()
    {
        return true;
    }


}