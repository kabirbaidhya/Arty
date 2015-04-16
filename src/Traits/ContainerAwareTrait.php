<?php namespace Gckabir\Arty\Traits;

use Illuminate\Contracts\Container\Container as ContainerContract;

trait ContainerAwareTrait
{
    /**
     * The Ioc Container instance
     *
     * @var \Illuminate\Contracts\Container\Container
     */
    protected $app;

    /**
     * Sets the Container instance
     * @param  \Illuminate\Contracts\Container\Container $container
     * @return void
     */
    public function setContainer(ContainerContract $container)
    {
        $this->app = $container;
    }

    /**
     * Returns the Container instance
     * @return \Illuminate\Contracts\Container\Container
     */
    public function getContainer()
    {
        return $this->app;
    }
}
