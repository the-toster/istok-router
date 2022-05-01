<?php

declare(strict_types=1);

namespace Test\Tokenizer;


use Istok\Router\Tokenizer\Token;
use PHPUnit\Framework\TestCase;

final class TokenTest extends TestCase
{
    /** @test */
    public function it_can_detect_variable(): void
    {
        $token = new Token('{var}');
        $this->assertEquals('var', $token->variable);
        $this->assertFalse($token->wildcard);

        $token = new Token('{var');
        $this->assertEquals(null, $token->variable);
        $this->assertFalse($token->wildcard);

        $token = new Token('var');
        $this->assertEquals(null, $token->variable);


        $token = new Token('{var*}');
        $this->assertEquals('var', $token->variable);
        $this->assertTrue($token->wildcard);
    }

    /** @test */
    public function it_can_match(): void
    {
        $token = new Token('{var}');
        $this->assertTrue($token->match('any1'));
        $this->assertTrue($token->match('any2'));

        $token = new Token('{var');
        $this->assertTrue($token->match('{var'));
        $this->assertFalse($token->match('any'));
    }

}
