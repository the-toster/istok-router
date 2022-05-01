<?php

declare(strict_types=1);

namespace Istok\Router\Tokenizer;


final class Token
{
    public readonly ?string $variable;
    public readonly bool $wildcard;

    public function __construct(
        public readonly string $content
    )
    {
        if(strlen($this->content) > 2 && $this->content[0] === '{' && $this->content[-1] === '}') {
            $this->wildcard = $this->content[-2] === '*';
            $this->variable = substr($this->content, 1, $this->wildcard ? -2 : -1);
        } else {
            $this->variable = null;
            $this->wildcard = false;
        }
    }

    public function match(string $value): bool
    {
        return $this->variable || $this->content === $value;
    }
}
