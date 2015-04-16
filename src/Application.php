<?php namespace Gckabir\Arty;

use Exception;
use Gckabir\Arty\Core\ServiceContainer;
use Gckabir\Arty\Traits\ConfigurableTrait;
use Gckabir\Arty\Traits\ContainerAwareTrait;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Application as SymfonyApplication;
use Symfony\Component\Console\Command\Command as SymfonyCommand;

class Application extends SymfonyApplication
{
    use ContainerAwareTrait, ConfigurableTrait;

    const VERSION = '0.1.0';

    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct('Arty', static::VERSION);

        // Initialize the container with application instance
        $container = new ServiceContainer([
            'application'  => $this,
            'input' => new ArgvInput(),
            'output' => new ConsoleOutput(),
        ]);

        // make it accessible throughout the application class
        $this->setContainer($container);
    }

    /**
     * Runs the current application.
     *
     * @return int 0 if everything went fine, or an error code
     */
    public function run()
    {
        $exitCode = 0;
        try {

            // Boot all the services
            $this->app->boot();

            $exitCode = parent::run($this->app['input'], $this->app['output']);
        } catch (Exception $e) {

            // Catch all exceptions and show render it nicely
            $output = $this->app['output']->getErrorOutput();
            $this->renderException($e, $output);

            $exitCode = 1;
        }

        // exit with the exit code
        exit($exitCode);
    }

    /**
     * Adds a command object.
     *
     * If a command with the same name already exists, it will be overridden.
     *
     * @param Command $command A Command object
     *
     * @return Command The registered command
     *
     * @api
     */
    public function add(SymfonyCommand $command)
    {
        // make the container accessible to the commands
        $command->setContainer($this->app);

        // Bind the command into the container
        $this->app->instance($command->getKey(), $command);

        return parent::add($command);
    }

    /**
     * Gets the default commands that should always be available.
     *
     * @return Command[] An array of default Command instances
     */
    protected function getDefaultCommands()
    {
        return [];
    }

    /**
     * Makes sure that the Eloquent will be initialized when the services boots up
     *
     * @return void
     */
    public function bootEloquent()
    {
        $this->app->instance('eloquent.boot', true);
    }
}
