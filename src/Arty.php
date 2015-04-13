<?php namespace Gckabir\Arty;

use Exception;
use Gckabir\Arty\Core\IocContainer;
use Gckabir\Arty\Core\ServiceLoader;
use Gckabir\Arty\Traits\ConfigurableTrait;
use Gckabir\Arty\Traits\ContainerAwareTrait;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Output\ConsoleOutput;

class Arty extends Application
{
    use ContainerAwareTrait, ConfigurableTrait;

    const NAME = "Arty";
    const VERSION = '0.1.0';

    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct(static::NAME, static::VERSION);

        // Initialize the container with application instance
        // make it accessible throughout the application class
        $this->setContainer(new IocContainer(['arty'  => $this]));
    }

    public function run()
    {
        try {

            // Load all the services
            $serviceLoader = new ServiceLoader($this->app);
            $serviceLoader->boot();

            parent::run();
        } catch (Exception $e) {

            // Catch all exceptions and show render it nicely
            $output = (new ConsoleOutput())->getErrorOutput();
            $this->renderException($e, $output);
        }
    }

    public function add(SymfonyCommand $command)
    {
        // make the container accessible to the commands
        $command->setContainer($this->app);

        // Bind the command into the container
        $this->app->instance($command->getKey(), $command);

        return parent::add($command);
    }

    protected function getDefaultCommands()
    {
        return [];
    }
}
