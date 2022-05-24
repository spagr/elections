<?php

declare(strict_types=1);

namespace App\Parser;

class CsvParser
{
    /**
     * @param array $filterColumns<int>
     *
     * @return array<array-key, <array-key, mixed>>
     */
    public function parseString(string $csvContent, bool $skipHeader = true, array $filterColumns = []): array
    {
        $lines = explode(PHP_EOL, $csvContent);

        if ($skipHeader) {
            array_shift($lines);
        }

        $result = [];

        foreach ($lines as $line) {
            if (($line[0] ?? null) === null) {
                continue;
            }

            $columns = str_getcsv($line);

            if ($filterColumns !== []) {
                $columns = array_filter(
                    $columns,
                    fn (int $key): bool => in_array($key, $filterColumns, true),
                    ARRAY_FILTER_USE_KEY,
                );
            }

            $result[] = $columns;
        }

        return $result;
    }
}
