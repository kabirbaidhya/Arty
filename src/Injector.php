<?php namespace Gckabir\Arty;

use ReflectionMethod;

class Injector
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
