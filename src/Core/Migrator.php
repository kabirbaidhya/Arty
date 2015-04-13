<?php namespace Gckabir\Arty\Core;

use Gckabir\Arty\Traits\ContainerAwareTrait;
use Gckabir\Arty\Traits\MigrationTrait;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Database\ConnectionResolverInterface;
use Illuminate\Database\Migrations\MigrationRepositoryInterface;
use Illuminate\Database\Migrations\Migrator as LaravelMigrator;
use Illuminate\Contracts\Container\Container as ContainerContract;

class Migrator extends LaravelMigrator
{
    use ContainerAwareTrait, MigrationTrait;

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

        // Retrieve migration path and throw exception if it doesn't exist
        $path = $this->getMigrationPath(true);

        $this->requireFiles($path, $migrations);

        parent::runDown($migration, $pretend);
    }
}
