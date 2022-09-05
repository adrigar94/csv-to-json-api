<?php

namespace App\Tests\CsvToJson;

use App\CsvToJson;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CsvToJsonTest extends KernelTestCase
{
    public function testSomething()
    {
        $this->it_should_parse_csv_to_json();
    }

    private function it_should_parse_csv_to_json()
    {
        $csvToParse = "col1;col2\nval1.1;val1.2\nval2.1;val2.2";

        $csvToJson = new CsvToJson($csvToParse);
        $jsonResponse = $csvToJson->__invoke();

        $jsonExpected = '[{"col1":"val1.1","col2":"val1.2"},{"col1":"val2.1","col2":"val2.2"}]';
        $this->assertEquals($jsonExpected,$jsonResponse,"Parse JSON");
    }

}
