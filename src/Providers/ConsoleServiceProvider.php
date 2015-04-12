<?php namespace Gckabir\Arty\Providers;

use Gckabir\Arty\Traits\CommandsProviderTrait;
use Gckabir\Arty\AbstractServiceProvider as ServiceProvider;
use Gckabir\Arty\Commands\HelpCommand;
use Gckabir\Arty\Commands\ListCommand;

class ConsoleServiceProvider extends ServiceProvider
{
    use CommandsProviderTrait;

    public function register()
    {
        $this->registerCommands();
    }

    protected function commands()
    {
        return [
            'HelpCommand',
            'ListCommand',
        ];
    }

    /**
     * Register the "migrate" migration command.
     *
     * @return string
     */
    protected function getHelpCommand()
    {
        return new HelpCommand();
    }

    /**
     * Register the "rollback" migration command.
     *
     * @return string
     */
    protected function getListCommand()
    {
        return new ListCommand();
    }
}
