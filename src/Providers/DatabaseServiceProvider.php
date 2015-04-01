<?php namespace Gckabir\Arty\Providers;

use Gckabir\Arty\AbstractServiceProvider;
use Illuminate\Database\Capsule\Manager as CapsuleManager;

class DatabaseServiceProvider extends AbstractServiceProvider
{
    public function register()
    {
        $this->app->singleton('laravel.db', function () {

            $config = $this->app['config'];

            $capsule = new CapsuleManager();
            $capsule->addConnection($config['database'], 'default');

            $capsule->setAsGlobal();

            // Setup the Eloquent ORM...
            if ($config['eloquent']['boot'] == true) {
                $capsule->bootEloquent();
            }

            return $capsule->getDatabaseManager();
        });
    }
}
