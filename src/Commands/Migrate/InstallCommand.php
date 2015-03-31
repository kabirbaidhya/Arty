<?php namespace Gckabir\Arty\Commands\Migrate;

use Gckabir\Arty\Command;
use Symfony\Component\Console\Input\InputOption;
use Illuminate\Database\Migrations\MigrationRepositoryInterface;

class InstallCommand extends Command
{
    protected $name = 'migrate:install';
    protected $description = 'Create the migration repository';

    /**
     * The repository instance.
     *
     * @var \Illuminate\Database\Migrations\MigrationRepositoryInterface
     */
    protected $repository;

    /**
     * Inject dependencies
     * @param  \Illuminate\Database\Migrations\MigrationRepositoryInterface $repository
     * @return void
     */
    public function __construct(MigrationRepositoryInterface $repository)
    {
        parent::__construct();
        $this->repository = $repository;
    }

    protected function fire()
    {
        // $this->repository->setSource($this->input->getOption('database'));

        $this->repository->createRepository();

        $this->info("Migration table created successfully.");
    }

    // /**
    //  * Get the console command options.
    //  *
    //  * @return array
    //  */
    // protected function getOptions()
    // {
    //     return array(
    //         array('database', null, InputOption::VALUE_OPTIONAL, 'The database connection to use.'),
    //     );
    // }
}
