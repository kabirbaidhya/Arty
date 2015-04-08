<?php namespace Gckabir\Arty\Traits;

trait CommandsProviderTrait
{
    protected function provideCommands()
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
        foreach ($this->provideCommands() as $command) {
            $commandInstance = $this->{'get'.$command}();
            $application->add($commandInstance);
        }
    }
}
