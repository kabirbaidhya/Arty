<?php namespace Gckabir\Arty\Providers;

use Gckabir\Arty\AbstractServiceProvider;
use Illuminate\Database\Capsule\Manager as CapsuleManager;

class DatabaseServiceProvider extends AbstractServiceProvider
{
    public function register()
    {
        $this->app->singleton('laravel.db', function ($app) {

            $config = $app['config'];
            $default = $config['database.default'];
            $capsule = new CapsuleManager($app);
            $config['database.default'] = $default;

            $connections = $config['database.connections'];

            foreach ($connections as $key => $connectionConfig) {
                $name = $key;
                $capsule->addConnection($connectionConfig, $name);
            }

            $capsule->setAsGlobal();

            // Setup the Eloquent ORM...
            if ($config['eloquent.boot'] == true) {
                $capsule->bootEloquent();
            }

            return $capsule->getDatabaseManager();
        });
    }
}
