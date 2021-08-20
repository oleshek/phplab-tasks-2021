<?php

namespace arrays;

class Arrays implements ArraysInterface
{
    /**
     * @param array $input
     * @return array
     */
    public function repeatArrayValues(array $input): array
    {
        $output = [];
        foreach ($input as $digit) {
            for ($i = 0; $i < $digit; $i++) {
                $output[] = $digit;
            }
        }

        return $output;
    }

    /**
     * @param array $input
     * @return int
     */
    public function getUniqueValue(array $input): int
    {
        $countValuesArray = array_count_values($input);
        $uniqueValues = array_keys($countValuesArray, 1);

        if (empty($uniqueValues)) {
            return 0;
        }

        return min($uniqueValues);
    }

    /**
     * @param array $input
     * @return array
     */
    public function groupByTag(array $input): array
    {
        asort($input);

        $tagsToProducts = [];
        foreach ($input as $product) {
            foreach ($product['tags'] as $tag) {
                $tagsToProducts[$tag][] = $product['name'];
            }
        }

        ksort($tagsToProducts);

        return $tagsToProducts;
    }
}