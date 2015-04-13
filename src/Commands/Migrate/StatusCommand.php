<?php namespace Gckabir\Arty\Commands\Migrate;

use Gckabir\Arty\Traits\MigrationTrait;
use Gckabir\Arty\Traits\ArtyCommandTrait;
use Gckabir\Arty\Traits\ContainerAwareTrait;
use Gckabir\Arty\Core\Migrator as ArtyMigrator;
use Illuminate\Database\Console\Migrations\StatusCommand as LaravelStatusCommand;

class StatusCommand extends LaravelStatusCommand
{
    use ContainerAwareTrait, ArtyCommandTrait;
    use MigrationTrait;

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
