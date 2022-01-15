<?php

declare(strict_types=1);

require_once('./vendor/autoload.php');
require_once('./controllers/TestController.php');

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use SymphonyRouting\Controllers\TestController;

try {
    $getEndpoint = new Route(
        '/get-endpoint',
        ['controller' => TestController::class, 'method' => 'sayHi']
    );

    $postEndpoint = new Route(
        '/post-endpoint',
        ['controller' => TestController::class, 'method' => 'sayBye']
    );

    // Add Route object(s) to RouteCollection object
    $rootCollection = new RouteCollection();

    /**
     * for get methods
     * sets routes for get methods
     * and assigns the prefix api/v1
     */
    $v1RoutesGET = new RouteCollection();
    //Note name is just then I'm giving to this method,
    //it's just a label
    $v1RoutesGET->add("get_greeting", $getEndpoint);
    //set method to GET
    $v1RoutesGET->setMethods(['GET']);
    //assign prefix
    //endpoint now accessible via url/api/v1/get-endpoint
    $v1RoutesGET->addPrefix('/api/v1');


    /**
     * for post methods
     * sets routes for post methods
     * and assigns the prefix api/v1
     * refer to comments for $v1RoutesGet to better understand
     */
    $v1RoutesPOST = new RouteCollection();
    $v1RoutesPOST->add('post_endpoint', $postEndpoint);
    $v1RoutesPOST->setMethods(['POST']);
    $v1RoutesPOST->addPrefix('/api/v1');

    $rootCollection->addCollection($v1RoutesGET);
    $rootCollection->addCollection($v1RoutesPOST);

    // Init RequestContext object
    $context = new RequestContext('/');
    $context->fromRequest(Request::createFromGlobals());

    // Init UrlMatcher object
    $matcher = new UrlMatcher($rootCollection, $context);

    // Find the current route
    $parameters = $matcher->match($context->getPathInfo());

    // Return the controller for the current route
    $controller = new $parameters['controller']();
    $controller->{$parameters['method']}(new Request());

    exit;
} catch (ResourceNotFoundException $e) {

    //throws error if route is not found
    echo $e->getMessage();
} catch (MethodNotAllowedException $e) {

    //throws error if incorrect method used on existing route
    $context = new RequestContext('/');
    $context->fromRequest(Request::createFromGlobals());
    echo $context->getMethod(). " not allowed.";
}
