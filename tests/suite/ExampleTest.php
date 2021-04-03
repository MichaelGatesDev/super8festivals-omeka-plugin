<?php

class ExampleTest extends S8F_Test_AppTestCase
{
    public function testFoo()
    {
        $foo = "test";
        $bar = "test2";
        $this->assertTrue($foo === $bar, sprintf('Strings not equal'));
    }
}
