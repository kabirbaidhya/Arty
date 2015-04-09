<?php namespace Gckabir\Arty\Commands\Migrate;

use Gckabir\Arty\Migrator as ArtyMigrator;
use Gckabir\Arty\Traits\MigrationTrait;
use Gckabir\Arty\Traits\ConfirmableTrait;
use Gckabir\Arty\Traits\ArtyCommandTrait;
use Gckabir\Arty\Traits\ContainerAwareTrait;
use Illuminate\Database\Console\Migrations\ResetCommand as LaravelResetCommand;

class ResetCommand extends LaravelResetCommand
{
    use ContainerAwareTrait, ArtyCommandTrait;
    use ConfirmableTrait, MigrationTrait;

    /**
     * Create a new migration rollback command instance.
     *
     * @param \Gckabir\Arty\Migrator $migrator
     */
    public function __construct(ArtyMigrator $migrator)
    {
        parent::__construct($migrator);
    }
}
