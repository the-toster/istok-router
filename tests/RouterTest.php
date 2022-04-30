<?php

declare(strict_types=1);

namespace Test;

use Istok\Router\Match\Template;
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
        $route = new Route(new Template('Post /test/{id}/new/{url*}'), 'marker');
        $router->add($route);

        $result = $router->find('Post /test/abc/new/http://url.com');
        $this->assertEquals(new Result($route, ['id' => 'abc', 'url' => 'http://url.com']), $result);
    }

    /** @test */
    public function it_can_route_simple(): void
    {
        $router = new Router();
        $route = new Route(new Template('Post /test/abc'), 'marker');
        $router->add($route);

        $result = $router->find('Post /test/abc');
        $this->assertEquals(new Result($route, []), $result);
    }
}
