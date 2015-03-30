<?php namespace Gckabir\Arty;

abstract class AbstractServiceProvider
{
    protected $app;

    public function __construct(IocContainer $app)
    {
        $this->app = $app;
    }

    abstract public function register();
}
