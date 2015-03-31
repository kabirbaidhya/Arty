<?php namespace Gckabir\Arty;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command as SymfonyCommand;

class Arty extends Application
{
    const NAME = "Arty";
    const VERSION = '0.1.0';

    /**
     * The Ioc container instance
     *
     * @var \Gckabir\Arty\IocContainer
     */
    protected $app;

    public function __construct(array $config = array())
    {
        parent::__construct(static::NAME, static::VERSION);

        $this->setupIoC();
        $this->configure($config);
        $this->bootServices();
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

    public function configure(array $config = array())
    {
        $configuration = new Configuration();

        $this->app->instance('config', $configuration->all($config));
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
        if ($command instanceof Command) {
            $command->setContainer($this->app);
        }

        return parent::add($command);
    }
}
