<?php namespace Gckabir\Arty\Core;

use Mockery;
use Gckabir\Arty\TestCase;

class ContainerTest extends TestCase
{

    public function tearDown()
    {
        Mockery::close();
    }

    public function testRegisterInstancesIsWorkingWithParameters()
    {
        $foo = 'Foo';
        $bar = (object) ['word'    => 'hello world'];

        $container = new Container(['hello'  => 'world']);

        $container->registerInstances(['foo'    => $foo, 'bar'    => $bar]);

        $this->assertEquals($foo, $container->make('foo'));
        $this->assertEquals($bar, $container->make('bar'));
        $this->assertEquals('world', $container['hello']);
    }

    public function testBoot()
    {
        $container = $this->getMock('Gckabir\Arty\Core\Container', ['providers', 'getProviderInstance']);

        $testProviders = ['provider1', 'provider2', 'provider3', 'provider4'];
        $noOfProviders = count($testProviders);
        $container->expects($this->once())->method('providers')->will($this->returnValue($testProviders));

        $serviceProvider = Mockery::mock('Gckabir\Arty\Core\AbstractServiceProvider');
        $container->expects($this->exactly($noOfProviders))->method('getProviderInstance')->withAnyParameters()->will($this->returnValue($serviceProvider));

        $serviceProvider->shouldReceive('register')->times($noOfProviders);

        $container->boot();
    }
}
