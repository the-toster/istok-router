<?php

declare(strict_types=1);

namespace Istok\Router;

final class Router
{
    /** @var Route[] */
    private array $routes = [];

    public function add(Route $route): void
    {
        $this->routes[] = $route;
    }

    public function find(Request $request): ?Result
    {
        foreach ($this->routes as $route) {
            if ($route->template->match($request)) {
                return new Result($route, $route->template->extractArguments($request));
            }
        }
        return null;
    }
}
