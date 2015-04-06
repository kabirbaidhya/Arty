<?php namespace Gckabir\Arty;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Database\ConnectionResolverInterface;
use Illuminate\Database\Migrations\MigrationRepositoryInterface;
use Illuminate\Database\Migrations\Migrator as LaravelMigrator;
use Symfony\Component\Console\Output\ConsoleOutput;

class Migrator extends LaravelMigrator
{

    protected $app;

    /**
     * Create a new migrator instance.
     *
     * @param  \Illuminate\Database\Migrations\MigrationRepositoryInterface $repository
     * @param  \Illuminate\Database\ConnectionResolverInterface             $resolver
     * @param  \Illuminate\Filesystem\Filesystem                            $files
     * @param  \Gckabir\Arty\IocContainer                                   $container
     * @return void
     */
    public function __construct(MigrationRepositoryInterface $repository,
                                ConnectionResolverInterface $resolver,
                                Filesystem $files,
                                IocContainer $container
                                ) {
        parent::__construct($repository, $resolver, $files);
        $this->app = $container;
    }

    /**
     * Run "down" a migration instance. (Overridden)
     *
     * @param  object $migration
     * @param  bool   $pretend
     * @return void
     */
    protected function runDown($migration, $pretend)
    {
        $migrations = [
            $migration->migration,
        ];

        $path = $this->getMigrationPath();
        $this->requireFiles($path, $migrations);

        parent::runDown($migration, $pretend);
    }

    /**
     * Run the outstanding migrations at a given path.
     *
     * @param  string $path
     * @param  bool   $pretend
     * @return void
     */
    public function run($pretend = false)
    {
        $path = $this->getMigrationPath();
        parent::run($path, $pretend);
    }

    protected function getMigrationPath()
    {
        $fs = $this->files;
        $config = $this->app['config'];

        $migrationPath = $config['path'].'/'.$config['migrations.directory'];

        if (!$fs->isDirectory($migrationPath)) {
            $output = new ConsoleOutput();
            $fs->makeDirectory($migrationPath);
            $output->writeln("<info>Migration directory created:</info> {$migrationPath}");
        }

        return $migrationPath;
    }
}
