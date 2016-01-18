<?php

namespace Helmut\Forms\Providers;

use Illuminate\Support\ServiceProvider;

class Laravel extends ServiceProvider {

    /**
     * Register form bindings in the container.
     *
     * @return void
     */
    public function register()
    {
 		$this->app->bind('Helmut\Forms\Request', 'Helmut\Forms\Requests\Laravel');
    }

}