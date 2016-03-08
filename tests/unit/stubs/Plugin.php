<?php 

namespace Helmut\Forms\Testing\Stubs;

class Plugin extends \Helmut\Forms\Plugin {

    protected $customProperty;

    public function setCustomProperty($value) 
    {
        $this->customProperty = $value;
    }

    public function getCustomProperty()
    {
        return $this->customProperty;
    }

}
