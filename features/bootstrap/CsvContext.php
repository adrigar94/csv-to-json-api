<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use GuzzleHttp\Client;

/**
 * Defines application features from the specific context.
 */
class CsvContext implements Context
{
    private $client;
    private $csv;
    private $response;
    private $contentResponse;
    private $jsonResponse;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * @Given I have a CSV file :path_csv
     */
    public function iHaveACsvFile($path_csv)
    {
        $path_file = dirname(__FILE__) . '/../' . $path_csv;
        if (!file_exists($path_file)) {
            throw new Exception("File doesn't exists");
        }
        $this->csv = fopen($path_file, 'rb');
    }

    /**
     * @When I request a parse CSV file from :url
     */
    public function iRequestAParseCsvFileFrom($url)
    {

        $this->response = $this->client->request('POST', $url, [
            'multipart' => [
                [
                    'name'     => 'csv',
                    'contents' => $this->csv
                ],
            ]
        ]);

        if ($this->response->getStatusCode() != 200) {
            throw new Exception("Server error on request");
        }
    }

    /**
     * @Then The result is a success JSON response
     */
    public function theResultIsASuccessJsonResponse()
    {
        $this->contentResponse = $this->response->getBody()->getContents();
        if(!$this->isJson($this->contentResponse)){
            throw new Exception("Isn't a JSON response");
        }
        $this->jsonResponse = json_decode($this->contentResponse);

        if(isset($this->jsonResponse->status) AND $this->jsonResponse->status == "error"){
            throw new Exception("Error on parse JSON" . (isset($this->jsonResponse->message) ? " - ".$this->jsonResponse->message : ''));
        }
    }

    /**
     * @Then The result is a CSV parsed same a :path_json
     */
    public function theResultIsACsvParsedSameA($path_json)
    {
        $path_file = dirname(__FILE__) . '/../' . $path_json;
        if (!file_exists($path_file)) {
            throw new Exception("File doesn't exists");
        }

        return $this->jsonResponse == json_decode(file_get_contents($path_file));
    }

    private function isJson($string)
    {
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }
}
