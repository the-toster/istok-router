<?php

declare(strict_types=1);

namespace Test\Tokenizer;


use Istok\Router\Tokenizer\Token;
use Istok\Router\Tokenizer\TokenizedString;
use Istok\Router\Tokenizer\Tokenizer;
use PHPUnit\Framework\TestCase;

final class TokenizerTest extends TestCase
{
    /** @test */
    public function it_can_tokenize(): void
    {
        $tokens = [
            new Token('a'),
            new Token('bc'),
            new Token('cde')
        ];

        $expected1 = new TokenizedString($tokens, ' ', false);
        $this->assertEquals($expected1, (new Tokenizer())->tokenize('a bc cde', ' '));

        $expected2 = new TokenizedString($tokens, '/', false);
        $this->assertEquals($expected2, (new Tokenizer())->tokenize('a/bc/cde', '/'));

        $expected3 = new TokenizedString(array_reverse($tokens), '.', true);
        $this->assertEquals($expected3, (new Tokenizer())->tokenize('a.bc.cde', '.', true));

    }
}
