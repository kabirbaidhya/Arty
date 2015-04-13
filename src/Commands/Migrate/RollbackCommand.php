<?php namespace Gckabir\Arty\Commands\Migrate;

use Gckabir\Arty\Core\Migrator as ArtyMigrator;
use Gckabir\Arty\Traits\ConfirmableTrait;
use Gckabir\Arty\Traits\ArtyCommandTrait;
use Gckabir\Arty\Traits\ContainerAwareTrait;
use Gckabir\Arty\Traits\MigrationTrait;
use Illuminate\Database\Console\Migrations\RollbackCommand as LaravelRollbackCommand;

class RollbackCommand extends LaravelRollbackCommand
{
    use ContainerAwareTrait, ArtyCommandTrait;
    use ConfirmableTrait, MigrationTrait;

    /**
     * Create a new migration rollback command instance.
     *
     * @param  \Gckabir\Arty\Migrator $migrator
     * @return void
     */
    public function __construct(ArtyMigrator $migrator)
    {
        parent::__construct($migrator);
    }
}
