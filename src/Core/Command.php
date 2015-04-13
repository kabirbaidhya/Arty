<?php namespace Gckabir\Arty\Core;

use Illuminate\Console\Command as LaravelCommand;
use Gckabir\Arty\Traits\ContainerAwareTrait;
use Gckabir\Arty\Traits\ArtyCommandTrait;

class Command extends LaravelCommand
{
    use ContainerAwareTrait, ArtyCommandTrait;
}
