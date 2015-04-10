<?php namespace Gckabir\Arty;

use Illuminate\Support\Facades\Facade;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Gckabir\Arty\Traits\ContainerAwareTrait;
use Symfony\Component\Console\Output\ConsoleOutput;
use Gckabir\Arty\Traits\ConfigurationTrait;
use Exception;

class Arty extends Application
{
    use ContainerAwareTrait, ConfigurationTrait;

    const NAME = "Arty";
    const VERSION = '0.1.0';

    protected $config;

    public function __construct()
    {
        parent::__construct(static::NAME, static::VERSION);

        $this->setupIoC();
    }

    public function run()
    {
        try {
            $this->loadConfiguration();

            // After configuration has been loaded other things can boot up
            $this->bootServices();
            parent::run();
        } catch (Exception $e) {
            $output = (new ConsoleOutput())->getErrorOutput();
            $this->renderException($e, $output);
        }
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
