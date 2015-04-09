<?php namespace Gckabir\Arty\Commands\Migrate;

use Gckabir\Arty\Traits\MigrationTrait;
use Gckabir\Arty\Traits\ConfirmableTrait;
use Gckabir\Arty\Traits\ArtyCommandTrait;
use Gckabir\Arty\Traits\ContainerAwareTrait;
use Illuminate\Database\Console\Migrations\RefreshCommand as LaravelRefreshCommand;

class RefreshCommand extends LaravelRefreshCommand
{
    use ContainerAwareTrait, ArtyCommandTrait;
    use ConfirmableTrait, MigrationTrait;

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        if (! $this->confirmToProceed()) {
            return;
        }

        $database = $this->input->getOption('database');

        $this->call('migrate:reset', array(
            '--database' => $database, '--force' => true,
        ));

        // The refresh command is essentially just a brief aggregate of a few other of
        // the migration commands and just provides a convenient wrapper to execute
        // them in succession. We'll also see if we need to re-seed the database.
        $this->call('migrate', array(
            '--database' => $database, '--force' => true,
        ));

        if ($this->needsSeeding()) {
            $this->runSeeder($database);
        }
    }
}
