<?php namespace Gckabir\Arty;

use RuntimeException;
use Illuminate\Support\Facades\Facade;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Gckabir\Arty\Traits\ConfigureTrait;


class Arty extends Application
{
    use ConfigureTrait;

    const NAME = "Arty";
    const VERSION = '0.1.0';

    /**
     * The Ioc container instance
     *
     * @var \Gckabir\Arty\IocContainer
     */
    protected $app;
    protected $configured = false;

    public function __construct(array $config = array())
    {
        parent::__construct(static::NAME, static::VERSION);

        $this->setupIoC();
        $this->setupFacades();

        if (!empty($config)) {
            $this->configure($config);
        }
    }

    protected function getServiceProviders()
    {
        return [
            'InjectorServiceProvider',
            'FilesystemServiceProvider',
            'ComposerServiceProvider',
            'DatabaseServiceProvider',
            'MigrationServiceProvider',
        ];
    }

    protected function setupIoC()
    {
        $this->app = IocContainer::initialize();
        $this->app->instance('arty', $this);
    }

    protected function setupFacades()
    {
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

    public function add(SymfonyCommand $command)
    {
        // Do it only for Arty's commands
        if ($command instanceof Command) {
            $command->setContainer($this->app);
            $this->app->instance($command->getKey(), $command);
        }

        return parent::add($command);
    }

    public function run()
    {
        if (!$this->configured) {
            throw new RuntimeException("Arty has not been configured yet.");
        }
        parent::run();
    }
}
