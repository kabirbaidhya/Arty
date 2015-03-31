<?php namespace Gckabir\Arty;

abstract class AbstractServiceProvider
{
    /**
     * The Ioc container instance
     *
     * @var \Gckabir\Arty\IocContainer
     */
    protected $app;

    public function __construct(IocContainer $app)
    {
        $this->app = $app;
    }

    abstract public function register();
}
