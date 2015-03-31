<?php namespace Gckabir\Arty\Traits;

trait MigrationTrait
{
    /**
     * Get the path to the migration directory.
     *
     * @return string
     */
    protected function getMigrationPath()
    {
        $config = $this->app->make('config');
        $fs = $this->app->make('files');

        $migrationPath = $config['path'].'/'.$config['migrations']['directory'];

        if (!$fs->isDirectory($migrationPath)) {
            $fs->makeDirectory($migrationPath);
        }

        return $migrationPath;
    }
}
