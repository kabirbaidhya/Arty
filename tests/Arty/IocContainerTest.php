<?php namespace Gckabir\Arty;

use Mockery;

class IocContainerTest extends TestCase
{

    public function tearDown()
    {
        Mockery::close();
    }

    public function testConstructorIsWorkingWithParameters()
    {
        $foo = 'Foo';
        $bar = (object) ['stirng'    => 'hello world'];

        $container = new IocContainer(['foo'    => $foo, 'bar'    => $bar]);

        $this->assertTrue($container->bound('foo'));
        $this->assertEquals($foo, $container->make('foo'));
        $this->assertTrue($container->bound('bar'));
        $this->assertEquals($bar, $container->make('bar'));
    }
}
