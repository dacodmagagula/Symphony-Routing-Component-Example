<?php

declare(strict_types=1);

namespace SymphonyRouting\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TestController
{
    public function sayHi(Request $request)
    {
        echo "Hello there. Your current method is: ". $request->getMethod();
    }

    public function sayBye(Request $request)
    {
        //your function here

        try {

            //sends response per https://symfony.com/doc/current/components/http_foundation.html#response
            $response = new Response(
                json_encode($request->toArray()),
                Response::HTTP_OK,
                ['content-type' => 'application/json']
            );
            $response->send();
            exit;
        } catch (\Exception $e) {

            //sends error response
            $response = new Response(
                json_encode(["message" => $e->getMessage()]),
                Response::HTTP_BAD_REQUEST,
                ['content-type' => 'application/json']
            );
            $response->send();
            exit;
        }
    }
}
