<?php namespace Gckabir\Arty\Commands;

use Gckabir\Arty\Traits\MigrationTrait;
use Gckabir\Arty\Traits\ArtyCommandTrait;
use Gckabir\Arty\Traits\ConfirmableTrait;
use Gckabir\Arty\Traits\ContainerAwareTrait;
use Gckabir\Arty\Migrator as ArtyMigrator;
use Illuminate\Database\Console\Migrations\MigrateCommand as LaravelMigrateCommand;

class MigrateCommand extends LaravelMigrateCommand
{
    use ContainerAwareTrait, ArtyCommandTrait;
    use ConfirmableTrait, MigrationTrait;

    /**
     * Create a new migration command instance.
     *
     * @param \Gckabir\Arty\Migrator $migrator
     */
    public function __construct(ArtyMigrator $migrator)
    {
        parent::__construct($migrator);
    }

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

        $this->prepareDatabase();

        // The pretend option can be used for "simulating" the migration and grabbing
        // the SQL queries that would fire if the migration were to be run against
        // a database for real, which is helpful for double checking migrations.
        $pretend = $this->input->getOption('pretend');

        // Next, we will check to see if a path option has been defined. If it has
        // we will use the path relative to the root of this installation folder
        // so that migrations may be run for any path within the applications.
        if (! is_null($path = $this->input->getOption('path'))) {
            $path = $this->app['config']['path'].'/'.$path;
        } else {

            // Retrieve migration path and throw exception if it doesn't exist
            $path = $this->getMigrationPath(true);
        }

        $this->migrator->run($path, $pretend);

        // Once the migrator has run we will grab the note output and send it out to
        // the console screen, since the migrator itself functions without having
        // any instances of the OutputInterface contract passed into the class.
        foreach ($this->migrator->getNotes() as $note) {
            $this->output->writeln($note);
        }

        // Finally, if the "seed" option has been given, we will re-run the database
        // seed task to re-populate the database, which is convenient when adding
        // a migration and a seed at the same time, as it is only this command.
        if ($this->input->getOption('seed')) {
            $this->call('db:seed', ['--force' => true]);
        }
    }
}
