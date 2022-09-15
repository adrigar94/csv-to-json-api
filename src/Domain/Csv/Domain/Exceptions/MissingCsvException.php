<?php

namespace App\Domain\Csv\Domain\Exceptions;

use Exception;

final class MissingCsvException extends Exception
{
    const MESSAGE = 'exception.csv.is_missing';
    const CODE = 204;

    public function __construct()
    {
        parent::__construct(self::MESSAGE.'', self::CODE);
    }
}
