<?php

namespace App\Tests\Domain\Csv\Application\CsvToJson;

use App\Domain\Csv\Domain\Csv;
use App\Domain\Csv\Application\CsvToJson;
use App\Domain\Csv\Domain\Exceptions\MissingCsvException;
use App\Tests\Domain\Csv\Domain\CsvMother;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CsvToJsonTest extends KernelTestCase
{
    public function csvProvider(): array
    {
        return [
            [
                "col1;col2\nval1.1;val1.2\nval2.1;val2.2",
                '[{"col1":"val1.1","col2":"val1.2"},{"col1":"val2.1","col2":"val2.2"}]'
            ],
            [
                "col1;col2\n1;2\n1.1;2.2",
                '[{"col1":1,"col2":2},{"col1":1.1,"col2":2.2}]'
            ],
        ];
    }

    public function test_it_should_exception_if_file_is_missing(): void
    {
        $csvToJson = new CsvToJson();
        $this->expectExceptionObject(new MissingCsvException());
        $csvToJson();
    }

    public function test_it_should_create_csv(): void
    {
        $csv = CsvMother::create();
        $this->assertInstanceOf(Csv::class, $csv);
    }


    /**
     * @dataProvider csvProvider
     */
    public function test_it_should_parse_csv_to_json($csvToParse,$jsonExpected): void
    {
        $csvToJson = new CsvToJson();
        $csvToJson->setcsv(CsvMother::create($csvToParse,';'));
        $jsonResponse = $csvToJson();
        
        $this->assertEquals($jsonExpected, $jsonResponse, "Parse int to JSON");
    }
}
