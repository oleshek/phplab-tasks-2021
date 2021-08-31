<?php

use PHPUnit\Framework\TestCase;

class GetUniqueFirstLettersTest extends TestCase
{
    /**
     * @dataProvider positiveDataProvider
     */
    public function testPositive($input, $expected)
    {
        require_once __DIR__.'/../src/web/functions.php';

        $this->assertEquals($expected, getUniqueFirstLetters($input));
    }

    public function positiveDataProvider(): array
    {
        return [
            [[
                ["name" => "Nashville"],
                ["name" => "Boston"],
                ["name" => "North Carolina"],
                ["name" => "Atlanta"],
                ["name" => "Milwaukee"],
                ["name" => "Texas"],
                ["name" => "Washington"],
                ["name" => "Philadelphia"],
                ["name" => "LAS"],
                ["name" => "Charleston"],
                ["name" => "Orlando"],
                ["name" => "Virginia"],
                ["name" => "St Petersburg/Clearwater"],
                ["name" => "Rhode Island"],
                ["name" => "Florida"],
                ["name" => "Dr, Nashville, TN 37214, USA"],
                ["name" => "WWW"],
                ["name" => "ZZZ"],
                ["name" => "UUU"],
                ["name" => "UUU"],
                ["name" => "III"],
                ["name" => "QQQ"],
                ["name" => "XXX"],
                ["name" => "GGG EEE VVV"],
            ],
                ['A', 'B', 'C', 'D', 'F', 'G', 'I', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Z']
            ],
        ];
    }
}