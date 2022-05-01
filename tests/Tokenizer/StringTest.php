<?php

declare(strict_types=1);

namespace Test\Tokenizer;


use Istok\Router\Tokenizer\Token;
use Istok\Router\Tokenizer\TokenizedString;
use PHPUnit\Framework\TestCase;

final class StringTest extends TestCase
{
    /** @test */
    public function it_can_match_exactly_same(): void
    {
        $string1 = $this->tokenizedString('path to file');
        $string2 = $this->tokenizedString('path to file');
        $this->assertTrue($string1->match($string2));
    }

    /** @test */
    public function it_can_match_with_vars(): void
    {
        $string1 = $this->tokenizedString('{path} to {filename}');
        $string2 = $this->tokenizedString('path to file');
        $this->assertTrue($string1->match($string2));
    }

    /** @test */
    public function it_can_match_with_wildcard(): void
    {
        $string1 = $this->tokenizedString('path to {filename*}');
        $string2 = $this->tokenizedString('path to file1 file2 file3');
        $this->assertTrue($string1->match($string2));
    }

    /** @test */
    public function it_can_extract_basic_vars(): void
    {
        $string1 = $this->tokenizedString('{path} to {filename}');
        $string2 = $this->tokenizedString('p1 to file');
        $this->assertEquals(['path' => 'p1', 'filename' => 'file'], $string1->extract($string2));
    }

    /** @test */
    public function it_can_extract_with_wildcard(): void
    {
        $string1 = $this->tokenizedString('{path} to {filename*}');
        $string2 = $this->tokenizedString('p1 to file1 file2 file3');
        $this->assertEquals(['path' => 'p1', 'filename' => 'file1 file2 file3'], $string1->extract($string2));
    }

    /** @test */
    public function it_can_restore(): void
    {
        $string1 = $this->tokenizedString('1 2 3 4');
        $this->assertEquals('2 3 4', $string1->restoreFrom(2));
    }

    /** @test */
    public function it_can_restore_reversed(): void
    {

        $delimiter = ' ';
        $tokens = [];
        foreach (array_reverse(explode($delimiter, '1 2 3 4 5')) as $part) {
            $tokens[] = new Token($part);
        }

        $string1 = new TokenizedString($tokens, $delimiter, true);

        $this->assertEquals('2 3 4 5', $string1->restoreFrom(2));
    }

    private function tokenizedString(string $str): TokenizedString
    {
        $delimiter = ' ';
        $tokens = [];
        foreach (explode($delimiter, $str) as $part) {
            $tokens[] = new Token($part);
        }

        return new TokenizedString($tokens, $delimiter, false);
    }
}
