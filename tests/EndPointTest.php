<?php

declare(strict_types=1);

use GuzzleHttp\Exception\GuzzleException;
use PHPUnit\Framework\TestCase;

class EndPointTest extends TestCase
{
    private $http;
    public const PAYLOAD = ["name" => "Dolly","Surname" => "Parton"];

    public function setUp(): void
    {
        //started a server on my local via php -S 127.0.0.1:2007
        $this->http = new GuzzleHttp\Client(['base_uri' => 'http://127.0.0.1:2007/']);
    }

    public function testGetEndPoint()
    {
        $response = $this->http->request('GET', 'api/v1/get-endpoint');

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["content-type"][0];
        $this->assertEquals("application/json", $contentType);

        $responseToArray = json_decode((string)$response->getBody(), true);
        $this->assertSame("Hello there, my friend.", $responseToArray["greeting"]);
    }

    /**
     * @throws GuzzleException
     */
    public function testPostEndPoint()
    {
        $response = $this->http->post('api/v1/post-endpoint', [
            'headers' => [
                'Accept' => "application/json",
            ],
            'json' => self::PAYLOAD,
        ]);

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["content-type"][0];
        $this->assertEquals("application/json", $contentType);

        $responseToArray = json_decode((string)$response->getBody(), true);
        $this->assertSame(self::PAYLOAD, $responseToArray);
    }

    public function tearDown(): void
    {
        $this->http = null;
    }
}
