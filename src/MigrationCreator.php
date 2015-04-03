<?php namespace Gckabir\Arty;

use Illuminate\Database\Migrations\MigrationCreator as LaravelMigrationCreator;

class MigrationCreator extends LaravelMigrationCreator{

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