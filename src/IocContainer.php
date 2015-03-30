<?php namespace Gckabir\Arty;

use Illuminate\Container\Container;

class IocContainer extends Container
{
    public static function initialize()
    {
        $container = new static();

        static::setInstance($container);

        return $container;
    }
}
