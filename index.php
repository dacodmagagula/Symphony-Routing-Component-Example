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

    /**
     * for get methods
     * sets routes for get methods
     * and assigns the prefix api/v1
     */
    $getEndpoint = new Route(
        '/get-endpoint',// Your path
        // Your controller + the method you would like to call from the controller
        ['controller' => TestController::class, 'method' => 'sayHi']
    );
    $v1RoutesGET = new RouteCollection();
    // Note name is just then I'm giving to this method,
    // It's just a label
    $v1RoutesGET->add("get_greeting", $getEndpoint);
    // Set method to GET
    $v1RoutesGET->setMethods(['GET']);
    // Adds api/v1 prefix so URL is prefixed
    // Url will be baseURL/api/get-endpoint/
    $v1RoutesGET->addPrefix('/api/v1');


    /**
     * for post methods
     * sets routes for post methods
     * and assigns the prefix api/v1
     * refer to comments for $v1RoutesGet to better understand
     */
    $postEndpoint = new Route(
        '/post-endpoint',//Your path
        // Your controller + the method you would like to call from the controller
        ['controller' => TestController::class, 'method' => 'sayBye']
    );
    $v1RoutesPOST = new RouteCollection();
    // Note name is just then I'm giving to this method,
    // It's just a label
    $v1RoutesPOST->add('post_endpoint', $postEndpoint);
    $v1RoutesPOST->setMethods(['POST']);
    // Adds api/v1 prefix so URL is prefixed
    // Url will be baseURL/api/v1/post-endpoint/
    $v1RoutesPOST->addPrefix('/api/v1');

    // Create route collection and add routes
    // Add Route object(s) to RouteCollection object
    $rootCollection = new RouteCollection();
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
    $controller = new $parameters['controller'](new Request());
    $controller->{$parameters['method']}();

    exit;
} catch (ResourceNotFoundException $e) {

    // Throws error if route is not found
    echo $e->getMessage();
} catch (MethodNotAllowedException $e) {

    // Throws error if incorrect method used on existing route
    $context = new RequestContext('/');
    $context->fromRequest(Request::createFromGlobals());
    echo $context->getMethod(). " not allowed.";
}
