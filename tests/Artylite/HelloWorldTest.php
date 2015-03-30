<?php namespace Gckabir\Artylite;

class HelloWorldTest extends TestCase
{
    /**
     * Just a demo test
     */
    public function testThatItSaysHelloWorld()
    {
        $expected = "Hello World";

        $object = new HelloWorld();

        $this->assertEquals($expected, $object->sayHello());
    }
}
