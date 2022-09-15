<?php

namespace App\Domain\Csv\Application;

use App\Domain\Csv\Domain\Csv;
use App\Domain\Csv\Domain\Exceptions\MissingCsvException;

class CsvToJson
{
    private Csv $csv;

    public function __construct() {
    }

    public function setcsv(Csv $csv): void
    {
        $this->csv = $csv;
    }

    public function __invoke(): string
    {
        return $this->parseToJson();
    }

    public function parseToJson(): string
    {
        if(!isset($this->csv)){
            throw new MissingCsvException();
        }
        return json_encode($this->csv->getRowsInArray());
    }
}
