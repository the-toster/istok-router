<?php

declare(strict_types=1);

namespace Istok\Router;


interface Request
{
    public function find(string $key): ?string;
}
