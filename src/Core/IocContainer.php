<?php namespace Gckabir\Arty\Core;

use Illuminate\Container\Container;

class IocContainer extends Container
{
    /**
     * Ioc Container Constructor
     * @param array $bindings
     */
    public function __construct(array $bindings = array())
    {
        // Initialize the container with initial bindings
        foreach ($bindings as $key => $value) {
            $this->instance($key, $value);
        }
    }
}
