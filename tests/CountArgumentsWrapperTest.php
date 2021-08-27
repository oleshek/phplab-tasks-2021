<?php

use PHPUnit\Framework\TestCase;

class CountArgumentsWrapperTest extends TestCase
{
    protected $functions;

    protected function setUp(): void
    {
        $this->functions = new functions\Functions();
    }

    /**
     * @dataProvider negativeDataProvider
     */
    public function testNegative($input)
    {
        $this->expectException(InvalidArgumentException::class);
        $this->functions->countArgumentsWrapper(...$input);
    }

    public function negativeDataProvider(): array
    {
        return [
            [[false, true, 2, 2.5, null, [], new \stdClass()]],
        ];
    }
}