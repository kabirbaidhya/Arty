<?php namespace Gckabir\Arty\Providers;

use Gckabir\Arty\AbstractServiceProvider;
use Gckabir\Arty\Commands\MigrateCommand;
use Gckabir\Arty\Commands\Migrate\InstallCommand;
use Gckabir\Arty\Commands\Migrate\MakeCommand;
use Gckabir\Arty\Commands\Migrate\RefreshCommand;
use Gckabir\Arty\Commands\Migrate\ResetCommand;
use Gckabir\Arty\Commands\Migrate\RollbackCommand;
use Gckabir\Arty\Commands\Migrate\StatusCommand;
use Illuminate\Database\Migrations\Migrator;
use Illuminate\Database\Migrations\MigrationCreator;
use Illuminate\Database\Migrations\DatabaseMigrationRepository;

class MigrationServiceProvider extends AbstractServiceProvider
{
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

    /**
     * Register the migration repository service.
     *
     * @return void
     */
    protected function registerRepository()
    {
        $this->app->singleton('migration.repository', function ($app) {
            $table = $app['config']['migrations']['table'];

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

            return new Migrator($repository, $app['laravel.db'], $app['files']);
        });
    }

    protected function getCommands()
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

    /*
     * Register all of the migration commands.
     *
     * @return void
     */
    protected function registerCommands()
    {
        // $injector = $this->app->make('injector');
        $application = $this->app->make('arty');
        $commands = $this->getCommands();

        foreach ($commands as $command) {
            $key = $this->{'register'.$command}();
            $commandInstance = $this->app->make($key);
            $application->add($commandInstance);
        }
    }

    /**
     * Register the "migrate" migration command.
     *
     * @return string
     */
    protected function registerMigrateCommand()
    {
        $key = 'command.migrate';
        $this->app->singleton($key, function ($app) {
            return new MigrateCommand($app['migrator']);
        });

        return $key;
    }

    /**
     * Register the "rollback" migration command.
     *
     * @return string
     */
    protected function registerRollbackCommand()
    {
        $key = 'command.migrate.rollback';
        $this->app->singleton($key, function ($app) {
            return new RollbackCommand($app['migrator']);
        });

        return $key;
    }

    /**
     * Register the "reset" migration command.
     *
     * @return string
     */
    protected function registerResetCommand()
    {
        $key = 'command.migrate.reset';
        $this->app->singleton($key, function ($app) {
            return new ResetCommand($app['migrator']);
        });

        return $key;
    }

    /**
     * Register the "refresh" migration command.
     *
     * @return string
     */
    protected function registerRefreshCommand()
    {
        $key = 'command.migrate.refresh';
        $this->app->singleton($key, function () {
            return new RefreshCommand();
        });

        return $key;
    }

    /**
     * Register the "status" migration command.
     *
     * @return string
     */
    protected function registerStatusCommand()
    {
        $key = 'command.migrate.status';
        $this->app->singleton($key, function ($app) {
            return new StatusCommand($app['migrator']);
        });

        return $key;
    }

    /**
     * Register the "install" migration command.
     *
     * @return string
     */
    protected function registerInstallCommand()
    {
        $key = 'command.migrate.install';
        $this->app->singleton($key, function ($app) {
            return new InstallCommand($app['migration.repository']);
        });

        return $key;
    }

    /**
     * Register the "make" migration command.
     *
     * @return string
     */
    protected function registerMakeCommand()
    {
        $key = 'command.migrate.make';
        $this->registerCreator();

        $this->app->singleton($key, function ($app) {
            // Once we have the migration creator registered, we will create the command
            // and inject the creator. The creator is responsible for the actual file
            // creation of the migrations, and may be extended by these developers.
            $creator = $app['migration.creator'];

            $composer = $app['composer'];

            return new MakeCommand($creator, $composer);
        });

        return $key;
    }

    /**
     * Register the migration creator.
     *
     * @return void
     */
    protected function registerCreator()
    {
        $this->app->singleton('migration.creator', function ($app) {
            return new MigrationCreator($app['files']);
        });
    }
}
