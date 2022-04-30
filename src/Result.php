<?php

declare(strict_types=1);

namespace Istok\Router;


final class Result
{
    public function __construct(
        public readonly Route $route,
        public readonly array $arguments,
    )
    {
    }
}
