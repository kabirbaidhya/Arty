<?php namespace Gckabir\Arty\Providers;

use Gckabir\Arty\Injector;
use Gckabir\Arty\AbstractServiceProvider as ServiceProvider;

class InjectorServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('injector', function ($app) {

            return new Injector($app);

        });
    }
}
