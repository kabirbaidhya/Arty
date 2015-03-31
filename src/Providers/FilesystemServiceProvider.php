<?php namespace Gckabir\Arty\Providers;

use Illuminate\Filesystem\Filesystem;
use Gckabir\Arty\AbstractServiceProvider;

class FilesystemServiceProvider extends AbstractServiceProvider
{
    public function register()
    {
        $this->app->singleton('files', function ($app) {

            return new Filesystem();

        });
    }
}
