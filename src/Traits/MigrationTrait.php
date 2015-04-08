<?php namespace Gckabir\Arty\Traits;

use Symfony\Component\Console\Output\ConsoleOutput;

trait MigrationTrait
{
    /**
     * Get the path to the migration directory.
     *
     * @return string
     */
    public function getMigrationPath()
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
