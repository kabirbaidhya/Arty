<?php namespace Gckabir\Arty;

use Gckabir\Arty\Traits\MigrationTrait;
use Gckabir\Arty\Traits\ContainerAwareTrait;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Database\ConnectionResolverInterface;
use Illuminate\Database\Migrations\MigrationRepositoryInterface;
use Illuminate\Database\Migrations\Migrator as LaravelMigrator;
use Illuminate\Contracts\Container\Container as ContainerContract;

class Migrator extends LaravelMigrator
{
    use MigrationTrait, ContainerAwareTrait;

    /**
     * Create a new migrator instance.
     *
     * @param \Illuminate\Database\Migrations\MigrationRepositoryInterface $repository
     * @param \Illuminate\Database\ConnectionResolverInterface             $resolver
     * @param \Illuminate\Filesystem\Filesystem                            $files
     * @param \Illuminate\Contracts\Container\Container                    $container
     */
    public function __construct(MigrationRepositoryInterface $repository,
                                ConnectionResolverInterface $resolver,
                                Filesystem $files,
                                ContainerContract $container
                                ) {
        parent::__construct($repository, $resolver, $files);
        $this->setContainer($container);
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
}
