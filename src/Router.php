<?php

declare(strict_types=1);

namespace Istok\Router;

final class Router
{
    /** @var Route[] */
    private readonly array $routes;

    public function __construct(Route ...$routes)
    {
        $this->routes = $routes;
    }

    public function withRoute(Route $route): self
    {
        return new self($route, ...$this->routes);
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
