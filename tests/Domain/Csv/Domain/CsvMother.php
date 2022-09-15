<?php

namespace App\Tests\Domain\Csv\Domain;

use App\Domain\Csv\Domain\Csv;

final class CsvMother
{
    public static function create(
        string $file_content = null,
        string $separator = ",",
        string $endLine = PHP_EOL
    ): Csv {
        return new Csv(
            $file_content ?? self::randomCsv(),
            $separator,
            $endLine
        );
    }

    private static function randomCsv(): string
    {
        $csv = "";

        $cols = random_int(1, 10);
        $rows = random_int(4, 30);

        for ($i = 0; $i < $rows; $i++) {

            for ($z = 0; $z < $cols; $z++) {
                $csv .= self::generateRandomString();
                if ($z == $cols - 1) {
                    $csv .= "\n";
                } else {
                    $csv .= ",";
                }
            }
        }

        return $csv;
    }

    private static function generateRandomString($length = 5): string
    {
        return substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ ', ceil($length / strlen($x)))), 1, $length);
    }
}
