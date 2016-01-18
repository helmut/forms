<?php 

namespace Helmut\Forms\Fields\Checkboxes;

use Helmut\Forms\Field;

class Checkboxes extends Field {

    public $options = [];

    public $values = [];

    public function setOptions($options)
    {
        $this->options = $options;
        $this->values = [];
        foreach (array_keys($this->options) as $key) {
            $this->values[$key] = false;
        }
        return $this;
    }

    public function setChecked($keys = [])
    {
        if (count($keys)) {
            foreach ($keys as $key) {
                $this->defaults[$key] = true;
            }
        } else {
            $this->defaults = [];
            foreach (array_keys($this->options) as $key) {
                $this->defaults[$key] = true;
            }
        }
        return $this;
    }

    public function setUnchecked($keys = [])
    {
        if (count($keys)) {
            foreach ($keys as $key) {
                $this->defaults[$key] = false;
            }
        } else {
            $this->defaults = [];
            foreach (array_keys($this->options) as $key) {
                $this->defaults[$key] = false;
            }
        }
        return $this;
    }       

    public function getValues() 
    {
        $values = [];
        foreach (array_keys($this->options) as $key) {
            $values[$this->name.'_'.$key] = $this->values[$key];
        }
        return $values;
    }

    public function getButtons()
    {
        return [];
    }           

    public function getProperties() 
    {
        $properties = [];

        $options = [];
        foreach ($this->options as $name => $label) {
            $options[] = [  
                'name' => $this->name.'_'.$name, 
                'label'=>$label, 
                'checked' => $this->values[$name] ? true : false
            ];
        }
        return ['options' => $options];
    }

    public function setValuesFromDefaults($defaults)
    {
        foreach (array_keys($this->options) as $key) {
            if (isset($defaults[$key])) $this->values[$key] = $defaults[$key] ? true : false;
        }
    }

    public function setValuesFromModel($model)
    {
        foreach (array_keys($this->options) as $key) {
            if (property_exists($model, $this->name.'_'.$key)) $this->values[$key] = $model->{$this->name.'_'.$key} ? true : false;
        }

    }   

    public function setValuesFromRequest($request)
    {
        foreach (array_keys($this->options) as $key) {      
            $this->values[$key] = $request->get($this->name.'_'.$key) ? true : false;
        }
    }

    public function fillModelWithValues($model)
    {
        foreach (array_keys($this->options) as $key) {
            if (property_exists($model, $this->name.'_'.$key)) $model->{$this->name.'_'.$key} = $this->values[$key] ? 1 : 0;
        }
    }   

    public function validateRequired()
    {
        $checked = false;

        foreach (array_keys($this->options) as $key) {
            if ($this->values[$key]) $checked = true;
        }

        return $checked;
    }

}
