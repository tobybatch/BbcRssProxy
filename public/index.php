<?php
chdir('..');
include('vendor/autoload.php');

use Symfony\Component\HttpFoundation\Request;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

$router = new League\Route\RouteCollection;
$router->addRoute('GET', '/rss.xml', 'Controller::index');

$dispatcher = $router->getDispatcher();
$request = Request::createFromGlobals();
$response = $dispatcher->dispatch($request->getMethod(), $request->getPathInfo());
$response->send();
