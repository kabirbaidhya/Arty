<?php namespace Gckabir\Arty\Core;

abstract class AbstractServiceProvider extends AbstractContainerAware
{
    /**
     * Register the service
     *
     * @return void
     */
    abstract public function register();
}
