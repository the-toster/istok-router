<?php

declare(strict_types=1);

namespace Istok\Router\Tokenizer;


final class Tokenizer
{
    public function tokenize(string $input, string $delimiter = ' ', bool $reversed = false): TokenizedString
    {
        $parts = explode($delimiter, $input);

        if ($reversed) {
            $parts = array_reverse($parts);
        }

        $tokens = [];
        foreach ($parts as $part) {
            $tokens[] = new Token($part);
        }

        return new TokenizedString($tokens, $delimiter, $reversed);
    }
}
