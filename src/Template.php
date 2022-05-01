<?php

declare(strict_types=1);

namespace Istok\Router;


interface Template
{
    public function match(Request $request): bool;

    public function extractArguments(Request $request): array;
}
