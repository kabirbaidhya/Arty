<?php namespace Gckabir\Arty\Providers;

use Illuminate\Filesystem\Filesystem;
use Gckabir\Arty\Core\AbstractServiceProvider as ServiceProvider;

class FilesystemServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('files', function () {

            return new Filesystem();

        });
    }
}
