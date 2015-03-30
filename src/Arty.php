<?php namespace Gckabir\Arty;

use Symfony\Component\Console\Application;

class Arty extends Application
{
    const NAME = "Artylite";
    const VERSION = '0.1.0';
    const COMMANDS_BASE = 'Gckabir\Arty\Commands';

    protected $container;

    public function __construct(array $config = array())
    {
        parent::__construct(static::NAME, static::VERSION);

        $this->registerCommands();
        $this->setupContainer();
        $this->configure($config);
        $this->bootServices();
    }

    protected function getCommands()
    {
        return [
            'TestCommand',
            'MigrateCommand',
            'Migrate\InstallCommand',
            'Migrate\RefreshCommand',
            'Migrate\MakeCommand',
            'Migrate\ResetCommand',
            'Migrate\RollbackCommand',
            'Migrate\StatusCommand',
        ];
    }

    protected function getServiceProviders()
    {
        return [
            'DatabaseServiceProvider',
        ];
    }

    protected function setupContainer()
    {
        $this->container = IocContainer::initialize();
    }

    public function configure(array $config = array())
    {
        $configuration = new Configuration();

        $this->container->instance('config', $configuration->all($config));
    }

    protected function registerCommands()
    {
        $commands = $this->getCommands();
        foreach ($commands as $command) {
            $commandClass = __NAMESPACE__.'\\Commands\\'.$command;
            $this->add(new $commandClass());
        }
    }

    protected function bootServices()
    {
        $providers = $this->getServiceProviders();

        foreach ($providers as $provider) {
            $serviceProvider = __NAMESPACE__.'\\Providers\\'.$provider;
            (new $serviceProvider($this->container))->register();
        }
    }
}
