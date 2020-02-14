<?php

require_once('./vendor/autoload.php');
require_once('./controllers/TestController.php');

use SymphonyRouting\Controllers\TestController;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
 
try
{
	// print_r(getallheaders());
    $api = new Route(
      '/category',
      array('controller' => TestController::class, 'method'=>'sayBye')
    );

    $product = new Route(
      '/product',
      array('controller' => TestController::class, 'method'=>'sayHi')
    );
 


    // Add Route object(s) to RouteCollection object
    $rootCollection = new RouteCollection();

    $routesv1 = new RouteCollection();
    $routesv1->add('api', $api);
    $routesv1->add('product', $product);
    $routesv1->addPrefix('/api/v1');
    $routesv1->setMethods(['GET']);

    $rootCollection->addCollection($routesv1);

 
    // Init RequestContext object
    $context = new RequestContext('/');
    $context->fromRequest(Request::createFromGlobals());
    
 
    // Init UrlMatcher object
    $matcher = new UrlMatcher($rootCollection, $context);

    // Find the current route
 	$parameters = $matcher->match($context->getPathInfo());
    // Find the current route



 	$controller = new $parameters['controller'];
 	$controller->{$parameters['method']}();

    
    exit;
 

}

catch (ResourceNotFoundException $e)
{
  echo $e->getMessage();
}

catch (MethodNotAllowedException $e)
{
  echo $context->getMethod(). " not allowed.";
}