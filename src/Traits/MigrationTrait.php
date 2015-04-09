<?php namespace Gckabir\Arty\Traits;

use RuntimeException;

trait MigrationTrait
{
    /**
     * Get the path to the migration directory.
     *
     * @return string
     */
    public function getMigrationPath($check = false)
    {
        $config = $this->app['config'];
        $fs = $this->app['files'];

        $migrationPath = $config['path'].'/'.$config['migrations.directory'];

        if ($check && !$fs->isDirectory($migrationPath)) {
            throw new RuntimeException("Migration directory doesn't exist: ".$migrationPath);
        }

        return $migrationPath;
    }
}
