<?php namespace Gckabir\Arty;

use Gckabir\Arty\Traits\ContainerAwareTrait;
use Illuminate\Contracts\Container\Container as ContainerContract;

abstract class AbstractServiceProvider
{
    use ContainerAwareTrait;

    /**
     * Constructor
     * @param Illuminate\Contracts\Container\Container $container
     */
    public function __construct(ContainerContract $container)
    {
        $this->setContainer($container);
    }

    abstract public function register();
}
