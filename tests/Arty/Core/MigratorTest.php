<?php namespace Gckabir\Arty\Core;

use Mockery as M;
use Gckabir\Arty\TestCase;

class MigratorTest extends TestCase
{

    public function tearDown()
    {
        M::close();
    }

    private function getMocks(array $methods = array('resolve'))
    {
        $migrator = $this->getMock('Gckabir\Arty\Core\Migrator', $methods, [
            $repository = M::mock('Illuminate\Database\Migrations\MigrationRepositoryInterface'),
            $resolver = M::mock('Illuminate\Database\ConnectionResolverInterface'),
            $filesystem = M::mock('Illuminate\Filesystem\Filesystem'),
            M::mock('Illuminate\Contracts\Container\Container'),
        ]);

        return [$migrator, $repository, $filesystem, $resolver];
    }

    public function testMigrationAreRunUpWhenOutstandingMigrationsExist()
    {
        list($migrator, $repository, $filesystem) = $this->getMocks();

        $filesystem->shouldReceive('glob')->once()->with(__DIR__.'/*_*.php')->andReturn(array(
            __DIR__.'/2_bar.php',
            __DIR__.'/1_foo.php',
            __DIR__.'/3_baz.php',
        ));

        $filesystem->shouldReceive('requireOnce')->with(__DIR__.'/2_bar.php');
        $filesystem->shouldReceive('requireOnce')->with(__DIR__.'/1_foo.php');
        $filesystem->shouldReceive('requireOnce')->with(__DIR__.'/3_baz.php');
        $repository->shouldReceive('getRan')->once()->andReturn(array('1_foo'));
        $repository->shouldReceive('getNextBatchNumber')->once()->andReturn(1);
        $repository->shouldReceive('log')->once()->with('2_bar', 1);
        $repository->shouldReceive('log')->once()->with('3_baz', 1);

        $barMock = M::mock('stdClass');
        $barMock->shouldReceive('up')->once();
        $bazMock = M::mock('stdClass');
        $bazMock->shouldReceive('up')->once();
        $migrator->expects($this->at(0))->method('resolve')->with($this->equalTo('2_bar'))->will($this->returnValue($barMock));
        $migrator->expects($this->at(1))->method('resolve')->with($this->equalTo('3_baz'))->will($this->returnValue($bazMock));
        $migrator->run(__DIR__);
    }

    public function testUpMigrationCanBePretended()
    {
        list($migrator, $repository, $filesystem, $resolver) = $this->getMocks();

        $filesystem->shouldReceive('glob')->once()->with(__DIR__.'/*_*.php')->andReturn(array(
            __DIR__.'/2_bar.php',
            __DIR__.'/1_foo.php',
            __DIR__.'/3_baz.php',
        ));
        $filesystem->shouldReceive('requireOnce')->with(__DIR__.'/2_bar.php');
        $filesystem->shouldReceive('requireOnce')->with(__DIR__.'/1_foo.php');
        $filesystem->shouldReceive('requireOnce')->with(__DIR__.'/3_baz.php');
        $repository->shouldReceive('getRan')->once()->andReturn(array('1_foo'));
        $repository->shouldReceive('getNextBatchNumber')->once()->andReturn(1);
        $barMock = M::mock('stdClass');
        $barMock->shouldReceive('getConnection')->once()->andReturn(null);
        $barMock->shouldReceive('up')->once();
        $bazMock = M::mock('stdClass');
        $bazMock->shouldReceive('getConnection')->once()->andReturn(null);
        $bazMock->shouldReceive('up')->once();
        $migrator->expects($this->at(0))->method('resolve')->with($this->equalTo('2_bar'))->will($this->returnValue($barMock));
        $migrator->expects($this->at(1))->method('resolve')->with($this->equalTo('3_baz'))->will($this->returnValue($bazMock));
        $connection = M::mock('stdClass');
        $connection->shouldReceive('pretend')->with(M::type('Closure'))->andReturnUsing(function ($closure) {
            $closure();

            return array(array('query' => 'foo'));
        },
        function ($closure) {
            $closure();

            return array(array('query' => 'bar'));
        });
        $resolver->shouldReceive('connection')->with(null)->andReturn($connection);
        $migrator->run(__DIR__, true);
    }

    public function testNothingIsDoneWhenNoMigrationsAreOutstanding()
    {
        list($migrator, $repository, $filesystem) = $this->getMocks();

        $filesystem->shouldReceive('glob')->once()->with(__DIR__.'/*_*.php')->andReturn(array(
            __DIR__.'/1_foo.php',
        ));
        $filesystem->shouldReceive('requireOnce')->with(__DIR__.'/1_foo.php');
        $repository->shouldReceive('getRan')->once()->andReturn(array(
            '1_foo',
        ));
        $migrator->run(__DIR__);
    }

    public function testLastBatchOfMigrationsCanBeRolledBack()
    {
        list($migrator, $repository, $filesystem) = $this->getMocks(['getMigrationPath', 'requireFiles', 'resolve']);

        $repository->shouldReceive('getLast')->once()->andReturn([
            $fooMigration = (object) [ 'migration' => 'foo'],
            $barMigration = (object) [ 'migration' => 'bar'],
        ]);

        $migrator->expects($this->exactly(2))->method('getMigrationPath')->will($this->returnValue(__DIR__.'/migrations'));
        $migrator->expects($this->exactly(2))->method('requireFiles')->will($this->returnValue(true));

        $barMock = M::mock('stdClass');
        $fooMock = M::mock('stdClass');
        $fooMock->shouldReceive('down')->once();
        $barMock->shouldReceive('down')->once();

        $map = [
            ['foo', $fooMock],
            ['bar', $barMock],
        ];

        $migrator->expects($this->exactly(2))->method('resolve')->will($this->returnValueMap($map));

        $repository->shouldReceive('delete')->once()->with($fooMigration);
        $repository->shouldReceive('delete')->once()->with($barMigration);
        $migrator->rollback();
    }

    public function testResolveWorksFine()
    {
        list($migrator) = $this->getMocks(['resolve']);

        $fooMock = M::mock('stdClass');
        $barMock = M::mock('stdClass');
        $fooMock->shouldReceive('down')->once();
        $barMock->shouldReceive('down')->once();

        $map = [
            ['foo', $fooMock],
            ['bar', $barMock],
        ];

        $migrator->expects($this->exactly(2))->method('resolve')->will($this->returnValueMap($map));

        $this->assertEquals($fooMock, $migrator->resolve('foo'));
        $this->assertEquals($barMock, $migrator->resolve('bar'));

        $fooMock->down();
        $barMock->down();
    }
}
