<?php namespace Gckabir\Arty\Core;

use Gckabir\Arty\Traits\ContainerAwareTrait;
use Illuminate\Contracts\Container\Container as ContainerContract;

abstract class AbstractContainerAware
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
}
