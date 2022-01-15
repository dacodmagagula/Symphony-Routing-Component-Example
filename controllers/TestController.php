<?php

declare(strict_types=1);

namespace SymphonyRouting\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TestController
{
    public const APPLICATION_JSON = 'application/json';
    /**
     * @var Request
     */
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function sayHi()
    {
        //sends response per https://symfony.com/doc/current/components/http_foundation.html#response
        $response = new Response(
            json_encode(["greeting" => "Hello there, my friend."]),
            Response::HTTP_OK,
            ['content-type' => self::APPLICATION_JSON]
        );
        $response->send();
        exit;
    }

    public function sayBye()
    {
        //your excellent function here

        try {

            //sends response per https://symfony.com/doc/current/components/http_foundation.html#response
            $response = new Response(
                json_encode($this->request->toArray()),
                Response::HTTP_OK,
                ['content-type' => self::APPLICATION_JSON]
            );
            $response->send();
            exit;
        } catch (\Exception $e) {

            //sends error response
            $response = new Response(
                json_encode(["message" => $e->getMessage()]),
                Response::HTTP_BAD_REQUEST,
                ['content-type' => self::APPLICATION_JSON]
            );
            $response->send();
            exit;
        }
    }
}
