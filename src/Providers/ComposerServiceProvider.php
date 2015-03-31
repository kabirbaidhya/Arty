<?php namespace Gckabir\Arty\Providers;

use Gckabir\Arty\AbstractServiceProvider;
use Gckabir\Arty\Composer;

class ComposerServiceProvider extends AbstractServiceProvider
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
