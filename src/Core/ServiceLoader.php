<?php namespace Gckabir\Arty\Core;

class ServiceLoader extends AbstractContainerAware
{
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

    public function boot()
    {
        foreach ($this->providers() as $provider) {
            $this->getServiceProvider($provider)->register();
        }
    }

    protected function getServiceProvider($class)
    {
        $serviceProvider = 'Gckabir\\Arty\\Providers\\'.$class;

        return new $serviceProvider($this->app);
    }
}
