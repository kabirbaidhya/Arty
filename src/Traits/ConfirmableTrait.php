<?php namespace Gckabir\Arty\Traits;

trait ConfirmableTrait
{
    /**
     * Confirm before proceeding with the action
     *
     * @param  string $warning
     * @return bool
     */
    public function confirmToProceed($warning = 'Application In Production!')
    {
        if ($this->shouldConfirm()) {
            if ($this->option('force')) {
                return true;
            }

            $this->comment(str_repeat('*', strlen($warning) + 12));
            $this->comment('*     '.$warning.'     *');
            $this->comment(str_repeat('*', strlen($warning) + 12));
            $this->output->writeln('');

            $confirmed = $this->confirm('Do you really wish to run this command? [y/n]');

            if (! $confirmed) {
                $this->comment('Command Cancelled!');

                return false;
            }
        }

        return true;
    }

    /**
     * Should it confirm or not?
     *
     * @return bool
     */
    protected function shouldConfirm()
    {
        return function () { return $this->app['config']['environment'] == 'production'; };
    }
}
