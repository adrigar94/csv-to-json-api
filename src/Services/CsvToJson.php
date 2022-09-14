<?php

namespace App\Services;

class CsvToJson
{
    private string $csv;
    private string $separator;
    private string $newline;

    public function __construct()
    {
        $this->separator = ";";
        $this->newline = "\n";
    }

    public function setcsv(string $csv): void
    {
        $this->csv = $csv;
    }

    public function setseparator(string $separator): void
    {
        $this->separator = $separator;
    }

    public function setnewline(string $newline): void
    {
        $this->newline = $newline;
    }

    public function __invoke(): string
    {
        $arrayData = $this->csvToArray();
        return json_encode($arrayData);
    }

    private function csvToArray(): array
    {
        $data = [];
        $rows = explode($this->newline, $this->csv);

        $titles = false;
        foreach ($rows as $row) {
            if (!$titles) {
                $titles = explode($this->separator, $row);
                continue;
            }
            $fields = explode($this->separator, $row);
            $arrayRow = [];
            foreach ($fields as $key => $field) {
                if (is_numeric($field)) {
                    $arrayRow[$titles[$key]] = floatval($field);
                } else {
                    $arrayRow[$titles[$key]] = $field;
                }
            }
            $data[] = $arrayRow;
        }
        return $data;
    }
}
