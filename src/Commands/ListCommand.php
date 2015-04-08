<?php namespace Gckabir\Arty\Commands;

use Gckabir\Arty\Traits\ConfirmableTrait;
use Gckabir\Arty\Traits\ContainerAwareTrait;
use Gckabir\Arty\Traits\ArtyCommandTrait;
use Symfony\Component\Console\Command\ListCommand as SymfonyListCommand;

class ListCommand extends SymfonyListCommand
{
    use ContainerAwareTrait, ArtyCommandTrait;
    use ConfirmableTrait;

    protected $name = 'help';
}
