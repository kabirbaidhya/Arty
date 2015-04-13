<?php namespace Gckabir\Arty\Traits;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

trait ArtyCommandTrait
{

    /**
     * Returns Command key for this command
     * @return string
     */
    public function getKey()
    {
        return 'command.'.str_replace(':', '.', $this->name);
    }

    /**
     * Execute the console command.
     *
     * @param  \Symfony\Component\Console\Input\InputInterface   $input
     * @param  \Symfony\Component\Console\Output\OutputInterface $output
     * @throws \LogicException
     * @return mixed
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (method_exists($this, 'fire')) {
            return $this->fire();
        }

        parent::execute($input, $output);
    }
}
