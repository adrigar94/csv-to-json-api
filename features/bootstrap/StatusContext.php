<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use GuzzleHttp\Client;

/**
 * Defines application features from the specific context.
 */
class StatusContext implements Context
{

    protected $client;
    protected $response;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /**
     * @Given I am a unauthenticated client
     */
    public function iAmAUnauthenticatedClient()
    {
        $this->client = new Client([
            'base_uri' => 'http://127.0.0.1:8000'
        ]);

        $response = $this->client->get('/status');

        $responseCode = $response->getStatusCode();

        if ($responseCode != 200) {
            throw new Exception('Not able to access!');
        }

        return true;
    }

    /**
     * @When I request a check status from :arg1
     */
    public function iRequestACheckStatusFrom($arg1)
    {
        $this->response = $this->client->get($arg1);

        $responseContent = $this->response->getBody()->getContents();

        $jsonResponse = json_decode($responseContent);

        if(isset($jsonResponse->success)){
            return true;
        }

        return false;
    }

    /**
     * @Then The result should include a success True
     */
    public function theResultShouldIncludeASuccessTrueFrom()
    {
        $responseContent = $this->response->getBody()->getContents();

        $jsonResponse = json_decode($responseContent);

        if(isset($jsonResponse->success) AND $jsonResponse->success === true){
            return true;
        }

        return false;
    }
}
