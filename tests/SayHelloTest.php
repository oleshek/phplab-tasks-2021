<?php

use PHPUnit\Framework\TestCase;

class SayHelloTest extends TestCase
{
    protected $functions;

    protected function setUp(): void
    {
        $this->functions = new functions\Functions();
    }

    /**
     * @dataProvider positiveDataProvider
     */
    public function testPositive(string $expected)
    {
        $this->assertEquals($expected, $this->functions->sayHello());
    }

    public function positiveDataProvider(): array
    {
        return [
            ['Hello'],
        ];
    }
}