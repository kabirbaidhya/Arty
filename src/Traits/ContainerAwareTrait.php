<?php namespace Gckabir\Arty\Traits;

use Illuminate\Contracts\Container\Container as ContainerContract;

trait ContainerAwareTrait
{
    /**
     * The Ioc container instance
     *
     * @var \Illuminate\Contracts\Container\Container
     */
    protected $app;

    /**
     * Set the Ioc container instance
     * @param \Illuminate\Contracts\Container\Container $container
     * @return
     */
    public function setContainer(ContainerContract $container)
    {
        $this->app = $container;
    }
}
