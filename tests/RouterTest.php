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
        $route = new Route(new HttpTemplate('/test/{id}/new/{url*}'), 'marker');
        $router = new Router($route);

        $result = $router->find(new HttpRequest('/test/abc/new/http://url.com', 'post', 'example.com'));
        $this->assertEquals(new Result($route, ['id' => 'abc', 'url' => 'http://url.com']), $result);
    }

    /** @test */
    public function it_can_route_simple(): void
    {
        $route = new Route(new HttpTemplate('/test/abc'), 'marker');
        $router = new Router($route);

        $result = $router->find(new HttpRequest('/test/abc', 'post', 'example.com'));
        $this->assertEquals(new Result($route, []), $result);
    }

    /** @test */
    public function it_can_add_route(): void
    {
        $router = new Router(new Route(new HttpTemplate('/test/other'), 'other'));
        $route = new Route(new HttpTemplate('/test/abc'), 'marker');

        $router = $router->withRoute($route);

        $result = $router->find(new HttpRequest('/test/abc', 'post', 'example.com'));
        $this->assertEquals(new Result($route, []), $result);
    }
}
