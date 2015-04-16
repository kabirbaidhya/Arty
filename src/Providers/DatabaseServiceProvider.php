<?php namespace Gckabir\Arty\Providers;

use Gckabir\Arty\Exceptions\ConfigurationException;
use Illuminate\Database\Capsule\Manager as CapsuleManager;
use Gckabir\Arty\Core\AbstractServiceProvider as ServiceProvider;

class DatabaseServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('laravel.db', function ($app) {

            $config = $app['config'];

            // Get the default database from the configuration
            $default = $config['database.default'];

            // Create an capsule instance
            $capsule = new CapsuleManager($app);

            // Override the default value with the user's config value
            $config['database.default'] = $default;

            if (!isset($config['database.connections']) || empty($config['database.connections'])) {
                throw new ConfigurationException("Invalid database configuration");
            }

            $connections = $config['database.connections'];

            foreach ($connections as $name => $connectionConfig) {
                $capsule->addConnection($connectionConfig, $name);
            }

            $capsule->setAsGlobal();

            // Setup the Eloquent ORM...
            if ($this->app->bound('eloquent.boot') && $this->app['eloquent.boot'] === true) {
                $capsule->bootEloquent();
            }

            return $capsule->getDatabaseManager();
        });
    }
}
