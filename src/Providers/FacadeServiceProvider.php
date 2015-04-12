<?php namespace Gckabir\Arty\Providers;

use Illuminate\Support\Facades\Facade;
use Gckabir\Arty\AbstractServiceProvider as ServiceProvider;

class FacadeServiceProvider extends ServiceProvider
{

    /**
     * Register the service
     *
     * @return void
     */
    public function register()
    {
        // Setup facades
        Facade::setFacadeApplication($this->app);
    }
}
