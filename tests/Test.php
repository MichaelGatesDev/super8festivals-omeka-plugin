<?php

use PHPUnit\Framework\TestCase;

class Test extends TestCase
{
    public function testFoo()
    {
        $foo = "test";
        $bar = "test";
        $this->assertEquals(
            $foo,
            $bar,
        );
    }
}
