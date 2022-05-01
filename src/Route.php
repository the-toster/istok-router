<?php

declare(strict_types=1);

namespace Istok\Router;


final class Route
{
    public function __construct(
        public readonly Template $template,
        public readonly mixed $handler,
    )
    {
    }
}
