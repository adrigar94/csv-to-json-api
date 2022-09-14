<?php

namespace App\Services;

use App\Entities\Csv;
use Exception;

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
        if(!$this->csv){
            throw new Exception("CSV is missing");
        }
        return json_encode($this->csv->getRowsInArray());
    }
}
