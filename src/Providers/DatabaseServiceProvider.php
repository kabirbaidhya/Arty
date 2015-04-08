<?php namespace Gckabir\Arty\Providers;

use Illuminate\Database\Capsule\Manager as CapsuleManager;
use Gckabir\Arty\AbstractServiceProvider as ServiceProvider;

class DatabaseServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('laravel.db', function ($app) {

            $config = $app['config'];
            $default = $config['database.default'];
            $capsule = new CapsuleManager($app);
            $config['database.default'] = $default;

            $connections = $config['database.connections'];

            foreach ($connections as $name => $connectionConfig) {
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
