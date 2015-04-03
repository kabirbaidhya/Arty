<?php namespace Gckabir\Arty\Commands\Migrate;

use Illuminate\Database\Migrations\Migrator;
use Gckabir\Arty\Command;
use Gckabir\Arty\Traits\MigrationTrait;

class StatusCommand extends Command
{
    use MigrationTrait;

    protected $name = 'migrate:status';
    protected $description = 'Show a list of migrations up/down';

    /**
     * The migrator instance.
     *
     * @var \Illuminate\Database\Migrations\Migrator
     */
    protected $migrator;

    /**
     * Create a new migration rollback command instance.
     *
     * @param  \Illuminate\Database\Migrations\Migrator $migrator
     */
    public function __construct(Migrator $migrator)
    {
        parent::__construct();

        $this->migrator = $migrator;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        if ( ! $this->migrator->repositoryExists())
        {
            return $this->error('No migrations found.');
        }

        $ran = $this->migrator->getRepository()->getRan();

        $migrations = [];

        foreach ($this->getAllMigrationFiles() as $migration)
        {
            $migrations[] = in_array($migration, $ran) ? ['<info>Y</info>', $migration] : ['<fg=red>N</fg=red>', $migration];
        }

        if (count($migrations) > 0)
        {
            $this->table(['Ran?', 'Migration'], $migrations);
        }
        else
        {
            $this->error('No migrations found');
        }
    }

    /**
     * Get all of the migration files.
     *
     * @return array
     */
    protected function getAllMigrationFiles()
    {
        return $this->migrator->getMigrationFiles($this->getMigrationPath());
    }
}
