<?php

declare(strict_types=1);

namespace Istok\Router\Match;


final class TemplatePart
{
    public readonly ?string $name;
    public readonly bool $dynamic;
    public readonly bool $wildcard;

    public function __construct(string $content)
    {
        $this->dynamic = strlen($content) > 2 && $content[0] === '{' && $content[-1] === '}';
        $this->wildcard = $this->dynamic && $content[-2] === '*';

        $lastChar = $this->wildcard ? -2 : -1;
        $this->name = $this->dynamic ? substr($content, 1, $lastChar) : $content;
    }

    public function match(string $req): bool
    {
        return $this->dynamic || $req === $this->name;
    }
}
