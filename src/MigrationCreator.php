<?php namespace Gckabir\Arty;

use Illuminate\Filesystem\Filesystem;
use Gckabir\Arty\Traits\ContainerAwareTrait;
use Illuminate\Contracts\Container\Container as ContainerContract;
use Illuminate\Database\Migrations\MigrationCreator as LaravelMigrationCreator;

class MigrationCreator extends LaravelMigrationCreator
{
    use ContainerAwareTrait;

    /**
     * Create a new migration creator instance.
     *
     * @param  \Illuminate\Filesystem\Filesystem         $fs
     * @param  \Illuminate\Contracts\Container\Container $container
     * @return void
     */
    public function __construct(Filesystem $fs, ContainerContract $container)
    {
        parent::__construct($fs);
        $this->setContainer($container);
    }

    /**
     * Override the laravel's default migration stub files
     *
     * @return string
     */
    public function getStubPath()
    {
        return __DIR__.'/Misc/stubs';
    }
}
