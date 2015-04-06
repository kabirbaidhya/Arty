<?php namespace Gckabir\Arty\Commands\Migrate;

use Gckabir\Arty\Command;
use Gckabir\Arty\Migrator;

class StatusCommand extends Command
{

    protected $name = 'migrate:status';
    protected $description = 'Show a list of migrations up/down';

    /**
     * The migrator instance.
     *
     * @var \Gckabir\Arty\Migrator
     */
    protected $migrator;

    /**
     * Create a new migration rollback command instance.
     *
     * @param \Gckabir\Arty\Migrator $migrator
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
        if (! $this->migrator->repositoryExists()) {
            return $this->error('No migrations found.');
        }

        $ran = $this->migrator->getRepository()->getRan();

        $migrations = [];

        foreach ($this->getAllMigrationFiles() as $migration) {
            $migrations[] = in_array($migration, $ran) ? ['<info>Y</info>', $migration] : ['<fg=red>N</fg=red>', $migration];
        }

        if (count($migrations) > 0) {
            $this->table(['Ran?', 'Migration'], $migrations);
        } else {
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
        return $this->migrator->getMigrationFiles($this->migrator->getMigrationPath());
    }
}
