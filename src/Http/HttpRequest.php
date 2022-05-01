<?php

declare(strict_types=1);

namespace Istok\Router\Http;


use Istok\Router\Request;

final class HttpRequest implements Request
{
    public function __construct(
        readonly string $path,
        readonly string $method,
        readonly string $host
    ) {
    }

    public function find(string $key): ?string
    {
        return match ($key) {
            'host' => $this->host,
            'method' => $this->method,
            'path' => $this->path,
            default => null
        };
    }
}
