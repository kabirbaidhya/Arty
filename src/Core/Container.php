<?php namespace Gckabir\Arty\Core;

use Illuminate\Container\Container as LaravelContainer;

class Container extends LaravelContainer
{
    /**
     * Container Constructor
     * @param array $bindings
     */
    public function __construct(array $bindings = array())
    {
        // Bootstrap the application container.
        static::setInstance($this);

        $this->registerInstances($bindings);
    }

    /**
     * Register an existing instances as shared in the container.
     * @param  array $bindings
     * @return void
     */
    public function registerInstances(array $bindings)
    {
        // Initialize the ioc container with some initial bindings
        foreach ($bindings as $key => $value) {
            $this->instance($key, $value);
        }
    }

    /**
     * List of service providers
     * @return array
     */
    protected function providers()
    {
        return [
            'ConfigurationServiceProvider',
            'FacadeServiceProvider',
            'FilesystemServiceProvider',
            'ComposerServiceProvider',
            'DatabaseServiceProvider',
            'ConsoleServiceProvider',
            'MigrationServiceProvider',
        ];
    }

    /**
     * Gets the Service Provider instance
     * @param  string                                     $class
     * @return \Gckabir\Arty\Core\AbstractServiceProvider
     */
    protected function getProviderInstance($class)
    {
        $class = 'Gckabir\\Arty\\Providers\\'.$class;

        return new $class($this);
    }

    /**
     * Register all the service providers
     * @return void
     */
    public function boot()
    {
        foreach ($this->providers() as $provider) {
            $this->getProviderInstance($provider)->register();
        }
    }
}
