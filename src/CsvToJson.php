<?php

namespace App;

class CsvToJson
{
    private string $csv;
    private string $separator;
    private string $newline;

    public function __construct(string $csv, string $separator = ";", string $newline = "\n")
    {
        $this->csv = $csv;
        $this->separator = $separator;
        $this->newline = $newline;
    }

    public function __invoke(): string
    {
        $arrayData = $this->csvToArray();
        return json_encode($arrayData);
    }

    private function csvToArray()
    {
        $data = [];
        $rows = explode($this->newline,$this->csv);

        $titles = false;
        foreach ($rows as $i => $row) {
            if(!$titles){
                $titles = explode($this->separator,$row);
                continue;
            }
            $fields = explode($this->separator,$row);
            $arrayRow = [];
            foreach ($fields as $key => $field) {
                $arrayRow[$titles[$key]] = $field;
            }
            $data[] = $arrayRow;
        }
        return $data;
    }
}
