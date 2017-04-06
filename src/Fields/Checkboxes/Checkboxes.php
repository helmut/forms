<?php 

namespace Helmut\Forms\Fields\Checkboxes;

use Helmut\Forms\Field;

class Checkboxes extends Field {

    protected $default = [];
    protected $options = [];
    protected $values = [];

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
                $this->default[$key] = true;
            }
        } else {
            $this->defaults = [];
            foreach (array_keys($this->options) as $key) {
                $this->default[$key] = true;
            }
        }
        return $this;
    }

    public function setUnchecked($keys = [])
    {
        if (count($keys)) {
            foreach ($keys as $key) {
                $this->default[$key] = false;
            }
        } else {
            $this->defaults = [];
            foreach (array_keys($this->options) as $key) {
                $this->default[$key] = false;
            }
        }
        return $this;
    }       

    public function getValue() 
    {
        $values = [];
        foreach (array_keys($this->options) as $key) {
            $values[$this->name.'_'.$key] = $this->values[$key];
        }
        return $values;
    }

    public function getButtonName()
    {
        //
    }           

    public function renderWith() 
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
        $properties['options'] = $options;

        return $properties;
    }

    public function setValueFromDefault()
    {
        foreach (array_keys($this->options) as $key) {
            if (isset($this->default[$key])) $this->values[$key] = $this->default[$key] ? true : false;
        }
    }

    public function setValueFromModel($model)
    {
        foreach (array_keys($this->options) as $key) {
            if (property_exists($model, $this->name.'_'.$key)) $this->values[$key] = $model->{$this->name.'_'.$key} ? true : false;
        }

    }   

    public function setValueFromRequest($request)
    {
        foreach (array_keys($this->options) as $key) {      
            $this->values[$key] = $request->get($this->name.'_'.$key) ? true : false;
        }
    }

    public function fillModelWithValue($model)
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
