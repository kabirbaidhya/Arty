<?php namespace Gckabir\Arty;

use Illuminate\Filesystem\Filesystem;
use Gckabir\Arty\Traits\MigrationTrait;
use Illuminate\Database\Migrations\MigrationCreator as LaravelMigrationCreator;

class MigrationCreator extends LaravelMigrationCreator
{
    use MigrationTrait;

    protected $app;

    /**
     * Create a new migrator instance.
     *
     * @param  \Illuminate\Filesystem\Filesystem $fs
     * @param  \Gckabir\Arty\IocContainer        $container
     * @return void
     */
    public function __construct(Filesystem $fs, IocContainer $container)
    {
        parent::__construct($fs);
        $this->app = $container;
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
