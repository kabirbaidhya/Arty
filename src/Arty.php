<?php namespace Gckabir\Arty;

use Illuminate\Support\Fluent;
use Illuminate\Support\Facades\Facade;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Gckabir\Arty\Traits\ContainerAwareTrait;

class Arty extends Application
{
    use ContainerAwareTrait;

    const NAME = "Arty";
    const VERSION = '0.1.0';

    protected $config;

    public function __construct(Configuration $config)
    {
        parent::__construct(static::NAME, static::VERSION);

        $this->setupIoC();
        $this->config = $config;
    }

    public function run()
    {
        // After configuration has been loaded other things can boot up
        $this->configure()->bootServices();

        parent::run();
    }

    public function add(SymfonyCommand $command)
    {
        $command->setContainer($this->app);
        $this->app->instance($command->getKey(), $command);

        return parent::add($command);
    }

    protected function getDefaultCommands()
    {
        return [];
    }

    protected function configure()
    {
        $values = array_dot_once($this->config->all());
        $this->app->instance('config', new Fluent($values));

        return $this;
    }

    protected function getServiceProviders()
    {
        return [
            'InjectorServiceProvider',
            'FilesystemServiceProvider',
            'ComposerServiceProvider',
            'DatabaseServiceProvider',
            'ConsoleServiceProvider',
            'MigrationServiceProvider',
        ];
    }

    protected function setupIoC()
    {
        $container = IocContainer::initialize();
        $container->instance('arty', $this);
        $this->setContainer($container);

        // Setup facades
        Facade::setFacadeApplication($this->app);
    }

    protected function bootServices()
    {
        $providers = $this->getServiceProviders();

        foreach ($providers as $provider) {
            $serviceProvider = __NAMESPACE__.'\\Providers\\'.$provider;
            (new $serviceProvider($this->app))->register();
        }
    }
}
