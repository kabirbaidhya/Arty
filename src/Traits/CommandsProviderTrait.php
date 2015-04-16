<?php namespace Gckabir\Arty\Traits;

trait CommandsProviderTrait
{
    /**
     * Gets a list of the commands to be registered
     * @return array
     */
    protected function commands()
    {
        return [];
    }

    /*
     * Register all of the commands.
     *
     * @return void
     */
    protected function registerCommands()
    {
        foreach ($this->commands() as $command) {
            $commandInstance = $this->{'get'.$command}();

            // Add the command instance into the application
            $this->app['application']->add($commandInstance);
        }
    }
}
