<?php namespace Gckabir\Arty;

use Illuminate\Container\Container;

class IocContainer extends Container
{
    /**
     * Initializes the container and returns the instance
     * @param  array        $bindings
     * @return IocContainer
     */
    public static function initialize(array $bindings = array())
    {
        $container = new static();

        // Initialize the container with initial bindings
        foreach ($bindings as $key => $value) {
            $container->instance($key, $value);
        }

        static::setInstance($container);

        return $container;
    }
}
