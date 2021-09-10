<?php

namespace strings;

class Strings implements StringsInterface
{
    /**
     * The $input variable contains text in snake case (i.e. hello_world or this_is_home_task)
     * Transform it into camel cased string and return (i.e. helloWorld or thisIsHomeTask)
     * @see http://xahlee.info/comp/camelCase_vs_snake_case.html
     *
     * Make sure the next PHPDoc instructions will be added:
     * @param string $input
     * @return string
     */
    public function snakeCaseToCamelCase(string $input): string
    {
        return lcfirst(str_replace('_', '', ucwords($input, '_')));
    }

    /**
     * The $input variable contains multibyte text like 'ФЫВА олдж'
     * Mirror each word individually and return transformed text (i.e. 'АВЫФ ждло')
     * !!! do not change words order
     *
     * Make sure the next PHPDoc instructions will be added:
     * @param string $input
     * @return string
     */
    public function mirrorMultibyteString(string $input): string
    {
        preg_match_all('/./us', $input, $array);
        $array2 = implode('', array_reverse($array[0]));
        $array3 = explode(' ', $array2);

        return implode(' ', array_reverse($array3));
    }

    /**
     * My friend wants a new band name for her band.
     * She likes bands that use the formula: 'The' + a noun with first letter capitalized.
     * However, when a noun STARTS and ENDS with the same letter,
     * she likes to repeat the noun twice and connect them together with the first and last letter,
     * combined into one word like so (WITHOUT a 'The' in front):
     * dolphin -> The Dolphin
     * alaska -> Alaskalaska
     * europe -> Europeurope
     * Implement this logic.
     *
     * Make sure the next PHPDoc instructions will be added:
     * @param string $noun
     * @return string
     */
    public function getBrandName(string $noun): string
    {
        $noun = strtolower($noun);
        $first_letter = mb_substr($noun, 0, 1);
        $last_letter = mb_substr($noun, -1);

        if ($first_letter == $last_letter) {
            return ucfirst($noun).mb_substr($noun, 1);
        }

        return 'The '.ucfirst($noun);
    }
}