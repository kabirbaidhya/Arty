<?php namespace Gckabir\Arty\Providers;

use Gckabir\Arty\Migrator;
use Gckabir\Arty\MigrationCreator;
use Gckabir\Arty\Commands\MigrateCommand;
use Gckabir\Arty\Traits\CommandsProviderTrait;
use Gckabir\Arty\Commands\Migrate\InstallCommand;
use Gckabir\Arty\Commands\Migrate\MakeCommand;
use Gckabir\Arty\Commands\Migrate\RefreshCommand;
use Gckabir\Arty\Commands\Migrate\ResetCommand;
use Gckabir\Arty\Commands\Migrate\RollbackCommand;
use Gckabir\Arty\Commands\Migrate\StatusCommand;
use Gckabir\Arty\AbstractServiceProvider as ServiceProvider;
use Illuminate\Database\Migrations\DatabaseMigrationRepository;

class MigrationServiceProvider extends ServiceProvider
{
    use CommandsProviderTrait;
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerRepository();

        // Once we have registered the migrator instance we will go ahead and register
        // all of the migration related commands that are used by the "Artisan" CLI
        // so that they may be easily accessed for registering with the consoles.
        $this->registerMigrator();

        $this->registerCommands();
    }

    protected function commands()
    {
        return [
            'MigrateCommand',
            'InstallCommand',
            'RefreshCommand',
            'MakeCommand',
            'ResetCommand',
            'RollbackCommand',
            'StatusCommand',
        ];
    }

    /**
     * Register the migration repository service.
     *
     * @return void
     */
    protected function registerRepository()
    {
        $this->app->singleton('migration.repository', function ($app) {
            $table = $app['config']['migrations.table'];

            return new DatabaseMigrationRepository($app['laravel.db'], $table);
        });
    }

    /**
     * Register the migrator service.
     *
     * @return void
     */
    protected function registerMigrator()
    {
        // The migrator is responsible for actually running and rollback the migration
        // files in the application. We'll pass in our database connection resolver
        // so the migrator can resolve any of these connections when it needs to.
        $this->app->singleton('migrator', function ($app) {
            $repository = $app['migration.repository'];

            return new Migrator($repository, $app['laravel.db'], $app['files'], $app);
        });
    }

    /**
     * Register the migration creator.
     *
     * @return void
     */
    protected function registerCreator()
    {
        $this->app->singleton('migration.creator', function ($app) {
            return new MigrationCreator($app['files'], $app);
        });
    }

    /**
     * Register the "migrate" migration command.
     *
     * @return string
     */
    protected function getMigrateCommand()
    {
        return new MigrateCommand($this->app['migrator']);
    }

    /**
     * Register the "rollback" migration command.
     *
     * @return string
     */
    protected function getRollbackCommand()
    {
        return new RollbackCommand($this->app['migrator']);
    }

    /**
     * Register the "reset" migration command.
     *
     * @return string
     */
    protected function getResetCommand()
    {
        return new ResetCommand($this->app['migrator']);
    }

    /**
     * Register the "refresh" migration command.
     *
     * @return string
     */
    protected function getRefreshCommand()
    {
        return new RefreshCommand();
    }

    /**
     * Register the "install" migration command.
     *
     * @return string
     */
    protected function getInstallCommand()
    {
        return new InstallCommand($this->app['migration.repository']);
    }

    /**
     * Register the "status" migration command.
     *
     * @return string
     */
    protected function getStatusCommand()
    {
        return new StatusCommand($this->app['migrator']);
    }

    /**
     * Register the "make" migration command.
     *
     * @return string
     */
    protected function getMakeCommand()
    {
        // Once we have the migration creator registered, we will create the command
        // and inject the creator. The creator is responsible for the actual file
        // creation of the migrations, and may be extended by these developers.
        $this->registerCreator();

        $creator = $this->app['migration.creator'];
        $composer = $this->app['composer'];

        return new MakeCommand($creator, $composer);
    }
}
