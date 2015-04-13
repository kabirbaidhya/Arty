<?php namespace Gckabir\Arty\Core;

use Mockery;
use Gckabir\Arty\TestCase;

class ComposerTest extends TestCase
{

    public function tearDown()
    {
        Mockery::close();
    }

    public function testFindComposerWorksProperlyWhenComposerPharExists()
    {
        $fs = Mockery::mock('Illuminate\Filesystem\Filesystem');
        $fs->shouldReceive('exists')->once()->with(__DIR__.'/composer.phar')->andReturn(true);

        $runner = Mockery::mock('stdClass');
        $runner->shouldReceive('setCommandLine')->once()->with('"'.PHP_BINARY.'" composer.phar dump-autoload');
        $runner->shouldReceive('run')->once();

        $composer = $this->getMock('Gckabir\Arty\Core\Composer', ['getCommandRunner'], [$fs, __DIR__]);
        $composer->expects($this->once())->method('getCommandRunner')->will($this->returnValue($runner));
        $composer->dumpAutoloads();
    }

    public function testFindComposerWorksProperlyWhenComposerPharDoesntExist()
    {
        $fs = Mockery::mock('Illuminate\Filesystem\Filesystem');
        $fs->shouldReceive('exists')->once()->with(__DIR__.'/composer.phar')->andReturn(false);

        $runner = Mockery::mock('stdClass');
        $runner->shouldReceive('setCommandLine')->once()->with('composer dump-autoload');
        $runner->shouldReceive('run')->once();

        $composer = $this->getMock('Gckabir\Arty\Core\Composer', ['getCommandRunner'], [$fs, __DIR__]);
        $composer->expects($this->once())->method('getCommandRunner')->will($this->returnValue($runner));
        $composer->dumpAutoloads();
    }
}
