<?php namespace Gckabir\Arty;

use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Command extends SymfonyCommand
{
    /**
     * The input interface implementation.
     *
     * @var \Symfony\Component\Console\Input\InputInterface
     */
    protected $input;

    /**
     * The output interface implementation.
     *
     * @var \Symfony\Component\Console\Output\OutputInterface
     */
    protected $output;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name;

    /**
     * The Ioc container instance
     *
     * @var \Gckabir\Arty\IocContainer
     */
    protected $app;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description;

    /**
     * Create a new console command instance.
     */
    public function __construct()
    {
        parent::__construct($this->name);

        // We will go ahead and set the name, description, and parameters on console
        // commands just to make things a little easier on the developer. This is
        // so they don't have to all be manually specified in the constructors.
        $this->setName($this->name);
        $this->setDescription($this->description);

        $this->specifyParameters();
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [];
    }

    /**
     * Run the console command.
     *
     * @param  \Symfony\Component\Console\Input\InputInterface   $input
     * @param  \Symfony\Component\Console\Output\OutputInterface $output
     * @return int
     */
    public function run(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;

        $this->output = $output;

        return parent::run($input, $output);
    }

    /**
     * Execute the console command.
     *
     * @param  \Symfony\Component\Console\Input\InputInterface   $input
     * @param  \Symfony\Component\Console\Output\OutputInterface $output
     * @return mixed
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (method_exists($this, 'fire')) {
            return $this->fire();
        }

        throw new \LogicException("The fire() has not been implemented in ".get_class($this));
    }

    /**
     * Write a string as information output.
     *
     * @param  string $string
     * @return void
     */
    public function info($string)
    {
        $this->output->writeln("<info>$string</info>");
    }

    /**
     * Write a string as standard output.
     *
     * @param  string $string
     * @return void
     */
    public function line($string)
    {
        $this->output->writeln($string);
    }

    /**
     * Write a string as comment output.
     *
     * @param  string $string
     * @return void
     */
    public function comment($string)
    {
        $this->output->writeln("<comment>$string</comment>");
    }

    /**
     * Write a string as question output.
     *
     * @param  string $string
     * @return void
     */
    public function question($string)
    {
        $this->output->writeln("<question>$string</question>");
    }

    /**
     * Write a string as error output.
     *
     * @param  string $string
     * @return void
     */
    public function error($string)
    {
        $this->output->writeln("<error>$string</error>");
    }

    /**
     * Specify the arguments and options on the command.
     *
     * @return void
     */
    protected function specifyParameters()
    {
        // We will loop through all of the arguments and options for the command and
        // set them all on the base command instance. This specifies what can get
        // passed into these commands as "parameters" to control the execution.
        foreach ($this->getArguments() as $arguments) {
            call_user_func_array(array($this, 'addArgument'), $arguments);
        }

        foreach ($this->getOptions() as $options) {
            call_user_func_array(array($this, 'addOption'), $options);
        }
    }

    public function setContainer(IocContainer $container)
    {
        $this->app = $container;
    }
}
