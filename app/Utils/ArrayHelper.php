<?php

namespace App\Utils;

class ArrayHelper
{
    /**
     * Format objectives input into a clean array of non-empty strings
     * 
     * @param mixed $input The input to format (array, string, or null)
     * @return array The formatted array of objectives
     */
    public static function formatObjectives($input): array
    {
        if (is_array($input)) {
            return array_values(array_filter(array_map('trim', $input)));
        }

        if (is_string($input)) {
            return array_values(array_filter(
                array_map('trim', explode("\n", $input)),
                fn($item) => $item !== ''
            ));
        }

        return [];
    }
}
