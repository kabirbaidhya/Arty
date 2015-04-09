<?php namespace Gckabir\Arty\Commands\Migrate;

use PDOException;
use Gckabir\Arty\Traits\ArtyCommandTrait;
use Gckabir\Arty\Traits\ContainerAwareTrait;
use Gckabir\Arty\Traits\MigrationTrait;
use Illuminate\Database\Console\Migrations\InstallCommand as LaravelInstallCommand;

class InstallCommand extends LaravelInstallCommand
{
    use ContainerAwareTrait, ArtyCommandTrait;
    use MigrationTrait;

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        try {
            parent::fire();
        } catch (PDOException $e) {
            if (@$e->errorInfo[1] != 1050) {
                throw $e;
            }

            $this->info('Migration table already exists');
        }

        $this->checkMigrationDirectory();
    }

    protected function checkMigrationDirectory()
    {
        $fs = $this->app['files'];
        $migrationPath = $this->getMigrationPath();

        if (!$fs->isDirectory($migrationPath)) {
            $this->line('');
            $this->info('Migration directory does not exist');
            $confirmed = $this->confirm('Do you wish to create it? [y/n]');

            if ($confirmed) {
                if ($fs->makeDirectory($migrationPath)) {
                    $this->line('<info>Directory Created:</info> '.$migrationPath);
                } else {
                    $this->error('Error creating directory; please create it manually');
                }
            } else {
                $this->info('Please create a it manually');
            }
        }
        $this->line('');
    }
}
