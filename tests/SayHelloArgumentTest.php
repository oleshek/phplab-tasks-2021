<?php

use PHPUnit\Framework\TestCase;

class SayHelloArgumentTest extends TestCase
{
    protected $functions;

    protected function setUp(): void
    {
        $this->functions = new functions\Functions();
    }

    /**
     * @dataProvider positiveDataProvider
     */
    public function testPositive(string $expected, $input)
    {
        $this->assertEquals($expected, $this->functions->sayHelloArgument($input));
    }

    public function positiveDataProvider(): array
    {
        return [
            ['Hello Leo', 'Leo'],
            ['Hello 123', 123],
            ['Hello 123.45', 123.45],
            ['Hello 1', true],
            ['Hello ', false],
        ];
    }
}