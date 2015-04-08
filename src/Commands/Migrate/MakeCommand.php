<?php namespace Gckabir\Arty\Commands\Migrate;

use Gckabir\Arty\Command;
use Gckabir\Arty\Composer;
use Gckabir\Arty\MigrationCreator;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class MakeCommand extends Command
{

    protected $name = 'make:migration';
    protected $description = 'Create a new migration file';

    /**
     * The migration creator instance.
     *
     * @var \Gckabir\Arty\MigrationCreator
     */
    protected $creator;

    /**
     * @var \Gckabir\Arty\Composer
     */
    protected $composer;

    /**
     * Create a new migration install command instance
     * @param \Gckabir\Arty\MigrationCreator $creator
     * @param \Gckabir\Arty\Composer         $composer
     */
    public function __construct(MigrationCreator $creator, Composer $composer)
    {
        parent::__construct();

        $this->creator = $creator;
        $this->composer = $composer;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        // It's possible for the developer to specify the tables to modify in this
        // schema operation. The developer may also specify if this table needs
        // to be freshly created so we can create the appropriate migrations.
        $name = $this->input->getArgument('name');

        $table = $this->input->getOption('table');

        $create = $this->input->getOption('create');

        if (! $table && is_string($create)) {
            $table = $create;
        }

        // Now we are ready to write the migration out to disk. Once we've written
        // the migration out, we will dump-autoload for the entire framework to
        // make sure that the migrations are registered by the class loaders.
        $this->writeMigration($name, $table, $create);

        $this->composer->dumpAutoloads();
    }

    /**
     * Write the migration file to disk.
     *
     * @param  string $name
     * @param  string $table
     * @param  bool   $create
     * @return string
     */
    protected function writeMigration($name, $table, $create)
    {
        $path = $this->creator->getMigrationPath();

        $file = pathinfo($this->creator->create($name, $path, $table, $create), PATHINFO_FILENAME);

        $this->line("<info>Created Migration:</info> $file");
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array(
            array('name', InputArgument::REQUIRED, 'The name of the migration'),
        );
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array(
            ['create', null, InputOption::VALUE_OPTIONAL, 'The table to be created.'],

            ['table', null, InputOption::VALUE_OPTIONAL, 'The table to migrate.'],
        );
    }
}
