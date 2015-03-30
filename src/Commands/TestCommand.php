<?php namespace Gckabir\Arty\Commands;

use Gckabir\Arty\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TestCommand extends Command
{
    protected $name = 'test';

    protected $description = 'Just Testing';

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("hello");
    }
}
