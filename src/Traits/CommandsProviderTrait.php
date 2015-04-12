<?php namespace Gckabir\Arty\Traits;

trait CommandsProviderTrait
{
    protected function commands()
    {
        return [];
    }

    /*
     * Register all of the migration commands.
     *
     * @return void
     */
    protected function registerCommands()
    {
        $application = $this->app['arty'];
        foreach ($this->commands() as $command) {
            $commandInstance = $this->{'get'.$command}();
            $application->add($commandInstance);
        }
    }
}
