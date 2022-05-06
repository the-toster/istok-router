<?php

declare(strict_types=1);

namespace Istok\Router\Tokenizer;

/** @property-read array<int,Token> $tokens */
final class TokenizedString
{
    public readonly int $size;
    public readonly Token $lastToken;

    public function __construct(
        public readonly array $tokens,
        private readonly string $delimiter,
        private readonly bool $reversed
    ) {
        $this->size = count($this->tokens);
        if ($this->size === 0) {
            throw new \InvalidArgumentException('At least one token required');
        }

        $this->lastToken = $this->tokens[$this->size - 1];
    }

    public function getContent(int $place): string
    {
        return $this->tokens[$place]->content;
    }

    public function match(TokenizedString $input): bool
    {
        if ($input->size < $this->size) {
            return false;
        }

        foreach ($this->tokens as $place => $token) {
            if (!$token->match($input->getContent($place))) {
                return false;
            }
        }

        if ($input->size > $this->size) {
            return $this->lastToken->wildcard;
        }

        return true;
    }

    public function extract(TokenizedString $input): array
    {
        $r = [];
        foreach ($this->tokens as $place => $token) {
            if ($token->variable) {
                $r[$token->variable] = $input->getContent($place);
            }
        }

        if ($input->size > $this->size) {
            /** @psalm-suppress PossiblyNullArrayOffset */
            $r[$this->lastToken->variable] = $input->restoreFrom($this->size);
        }

        return $r;
    }

    public function restoreFrom(int $place): string
    {
        $parts = $this->reversed ? array_reverse($this->tokens) : $this->tokens;
        return implode($this->delimiter, array_column(array_slice($parts, $place - 1), 'content'));
    }
}
