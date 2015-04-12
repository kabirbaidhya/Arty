<?php namespace Gckabir\Arty;

class CommandRunner
{
    protected $command;

    public function setCommandLine($command)
    {
        $this->command = $command;
    }

    public function run()
    {
        system(trim($this->command));
    }
}
