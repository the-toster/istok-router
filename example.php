<?php

declare(strict_types=1);

require "vendor\autoload.php";

use Istok\Router\Router;
use Istok\Router\Route;
use Istok\Router\Http\HttpTemplate;
use Istok\Router\Http\HttpRequest;

$route = new Route(
    new HttpTemplate('/post/{id}/show', 'GET', '{user}.example.com'),
    fn($id, $user) => print "User: $user, id: $id"
);

$router = new Router();
$router->add($route);

$request = new HttpRequest('/post/abc/show', 'GET', 'user1.example.com');

$result = $router->find($request);

($result->route->handler)(...$result->arguments);
