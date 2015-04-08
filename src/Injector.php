<?php namespace Gckabir\Arty;

use ReflectionMethod;
use Gckabir\Arty\Traits\ContainerAwareTrait;
use Illuminate\Contracts\Container\Container as ContainerContract;

class Injector
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

    public function inject($object, $method)
    {
        $className = get_class($object);
        $reflection = new ReflectionMethod($className, $method);

        $parameters = $reflection->getParameters();

        $injections = [];
        foreach ($parameters as $parameter) {
            $class = $parameter->getClass();

            if (!$class) {
                $injections[] = null;
                continue;
            }

            $class = $class->name;

            $injections = $this->app->make($class);
        }

        call_user_func_array(array($object, $method), $injections);
    }
}
