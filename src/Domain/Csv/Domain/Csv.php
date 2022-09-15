<?php

namespace App\Domain\Csv\Domain;

class Csv
{
    private string $separator;
    private string $endLine;
    private array $header;
    private array $rows;
    private string $file_content;


    public function __construct(
        string $file_content,
        string $separator = ",",
        string $endLine = PHP_EOL
    ) {
        $this->file_content = $file_content;
        $this->separator = $separator;
        $this->endLine = $endLine;
        $this->csvToRows();
    }

    public function getHeader(): array
    {
        return $this->header;
    }

    public function getRowsInArray(): array
    {
        return $this->rows;
    }


    private function csvToRows(): void
    {
        $data = [];
        $rows = explode($this->endLine, $this->file_content);

        foreach ($rows as $row) {
            if (empty($this->header)) {
                $this->header = explode($this->separator, $row);
                continue;
            }
            $fields = explode($this->separator, $row);
            $arrayRow = [];
            foreach ($fields as $key => $field) {
                if (is_numeric($field)) {
                    $arrayRow[$this->header[$key]] = floatval($field);
                } else {
                    $arrayRow[$this->header[$key]] = $field;
                }
            }
            $data[] = $arrayRow;
        }
        $this->rows = $data;
    }
}
