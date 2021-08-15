<?php

namespace basics;

class BasicsValidator implements BasicsValidatorInterface
{
    /**
     * Implement the check functionality described in the method getMinuteQuarter (BasicsInterface Class) which throws Exception.
     *
     * Make sure the next PHPDoc instructions will be added:
     * @param int $minute
     * @throws \InvalidArgumentException
     */
    public function isMinutesException(int $minute): void
    {
        if ($minute < 0 || $minute > 60) {
            throw new \InvalidArgumentException("Minutes value must be in interval from 0 to 59. Input was: $minute");
        }
    }

    /**
     * Implement the check functionality described in the method getMinuteQuarter (BasicsInterface Class) which throws Exception.
     *
     * Make sure the next PHPDoc instructions will be added:
     * @param int $year
     * @throws \InvalidArgumentException
     */
    public function isYearException(int $year): void
    {
        if ($year < 1900) {
            throw new \InvalidArgumentException("Year must not be less than 1900. Input was: $year");
        }
    }

    /**
     * Implement the check functionality described in the method getMinuteQuarter (BasicsInterface Class) which throws Exception.
     *
     * Make sure the next PHPDoc instructions will be added:
     * @param string $input
     * @throws \InvalidArgumentException
     */
    public function isValidStringException(string $input): void
    {
        $strLen = strlen($input);
        if ($strLen != 6) {
            throw new \InvalidArgumentException("Error input string must contains 6 digits. Input was: $input (length is $strLen digits).");
        }
    }
}