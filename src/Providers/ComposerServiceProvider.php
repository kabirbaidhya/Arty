<?php namespace Gckabir\Arty\Providers;

use Gckabir\Arty\Composer;
use Gckabir\Arty\AbstractServiceProvider as ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('composer', function ($app) {
            return new Composer($app['files'], $app['config']['path']);
        });
    }
}
