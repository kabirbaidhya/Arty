<?php namespace Gckabir\Arty\Providers;

use RuntimeException;
use Illuminate\Support\Fluent;
use Gckabir\Arty\Config\Config;
use Gckabir\Arty\Core\AbstractServiceProvider as ServiceProvider;

class ConfigurationServiceProvider extends ServiceProvider
{

    /**
     * Register the service
     *
     * @return void
     */
    public function register()
    {
        $instance = $this->loadConfiguration();

        // load configuration into the ioc container
        $this->app->instance('config', $instance);
    }

    /**
     * Gets the configuration instance
     * @return Illuminate\Support\Fluent
     */
    protected function loadConfiguration()
    {
        $config = $this->app['application']->getConfig();

        if (!($config instanceof Config)) {
            throw new RuntimeException("Arty hasn't been configured yet");
        }

        $values = array_dot_once($config->all());

        return new Fluent($values);
    }
}
