<?php 

namespace Helmut\Forms\Plugins\Memory;

use Helmut\Forms\Plugin;

class Memory extends Plugin {

    protected $token;

    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    public function onRender($form)
    {
        if (is_null($this->token)) {
            throw new \Exception('Memory plugin requires token to be set');
        }
    }

    public function onSubmitted($form)
    {
        // Save the data
    }

    public function onCompleted($form)
    {
        // Clear the data
    }


}