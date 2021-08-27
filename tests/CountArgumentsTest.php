<?php

use PHPUnit\Framework\TestCase;

class CountArgumentsTest extends TestCase
{
    protected $functions;

    protected function setUp(): void
    {
        $this->functions = new functions\Functions();
    }

    /**
     * @dataProvider positiveDataProvider
     */
    public function testPositive(array $expected, $firstArg = null, $secondArg = null)
    {
        if (isset($firstArg) && isset($secondArg)) {
            $this->assertEquals($expected, $this->functions->countArguments($firstArg, $secondArg));
        } elseif (isset($firstArg)) {
            $this->assertEquals($expected, $this->functions->countArguments($firstArg));
        } else {
            $this->assertEquals($expected, $this->functions->countArguments());
        }
    }

    public function positiveDataProvider(): array
    {
        return [
            [
                ['argument_count' => 0, 'argument_values' => []], // expected
                // no arguments
            ],
            [
                ['argument_count' => 1, 'argument_values' => ['one']], // expected
                'one' // 1 argument
            ],
            [
                ['argument_count' => 2, 'argument_values' => ['first', 'second']], // expected
                'first', 'second' // 2 arguments
            ],
        ];
    }
}