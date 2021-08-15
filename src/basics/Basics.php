<?php

namespace basics;

class Basics implements BasicsInterface
{
    private BasicsValidatorInterface $validator;

    public function __construct() {
        $this->validator = new BasicsValidator();
    }

    /**
     * @param int $minute
     * @return string
     * @throws \InvalidArgumentException
     */
    public function getMinuteQuarter(int $minute): string
    {
        $this->validator->isMinutesException($minute);

        if ($minute > 45 || $minute == 0) {
            return 'fourth';
        } elseif ($minute > 30) {
            return 'third';
        } elseif ($minute > 15) {
            return 'second';
        } else {
            return 'first';
        }
    }

    /**
     * @param int $year
     * @return boolean
     * @throws \InvalidArgumentException
     */
    public function isLeapYear(int $year): bool
    {
        $this->validator->isYearException($year);

        return date('L', strtotime("$year-01-01"));
    }

    /**
     * @param string $input
     * @return boolean
     * @throws \InvalidArgumentException
     */
    public function isSumEqual(string $input): bool
    {
        $this->validator->isValidStringException($input);

        return $input[0] + $input[1] + $input[2] == $input[3] + $input[4] + $input[5];
    }
}