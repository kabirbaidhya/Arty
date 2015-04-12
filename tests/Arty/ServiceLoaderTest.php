<?php namespace Gckabir\Arty;

use Mockery;

class ServiceLoaderTest extends TestCase
{

    public function tearDown()
    {
        Mockery::close();
    }

    public function testBoot()
    {
        $container = Mockery::mock('Illuminate\Contracts\Container\Container');

        $loader = $this->getMock('Gckabir\Arty\ServiceLoader', ['providers', 'getServiceProvider'], [$container]);

        $testProviders = ['provider1', 'provider2', 'provider3', 'provider4'];
        $noOfProviders = count($testProviders);
        $loader->expects($this->once())->method('providers')->will($this->returnValue($testProviders));

        $serviceProvider = Mockery::mock('Gckabir\Arty\AbstractServiceProvider');
        $serviceProvider->shouldReceive('register')->times($noOfProviders);

        $loader->expects($this->exactly($noOfProviders))->method('getServiceProvider')->withAnyParameters()->will($this->returnValue($serviceProvider));

        $loader->boot();
    }
}
