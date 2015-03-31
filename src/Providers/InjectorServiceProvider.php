<?php namespace Gckabir\Arty\Providers;

use Gckabir\Arty\Injector;
use Gckabir\Arty\AbstractServiceProvider;

class InjectorServiceProvider extends AbstractServiceProvider
{
    public function register()
    {
        $this->app->singleton('injector', function ($app) {

            return new Injector($app);

        });
    }
}
