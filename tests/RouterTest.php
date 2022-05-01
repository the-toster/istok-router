<?php

declare(strict_types=1);

namespace Test;

use Istok\Router\Http\HttpRequest;
use Istok\Router\Http\HttpTemplate;
use Istok\Router\Result;
use Istok\Router\Route;
use Istok\Router\Router;
use PHPUnit\Framework\TestCase;

final class RouterTest extends TestCase
{
    /** @test */
    public function it_can_route_with_wildcard(): void
    {
        $router = new Router();
        $route = new Route(new HttpTemplate('/test/{id}/new/{url*}'), 'marker');
        $router->add($route);

        $result = $router->find(new HttpRequest('/test/abc/new/http://url.com', 'post', 'example.com'));
        $this->assertEquals(new Result($route, ['id' => 'abc', 'url' => 'http://url.com']), $result);
    }

    /** @test */
    public function it_can_route_simple(): void
    {
        $router = new Router();
        $route = new Route(new HttpTemplate('/test/abc'), 'marker');
        $router->add($route);

        $result = $router->find(new HttpRequest('/test/abc', 'post', 'example.com'));
        $this->assertEquals(new Result($route, []), $result);
    }
}
