<?php

declare(strict_types=1);

namespace Istok\Router\Http;


use Istok\Router\Request;
use Istok\Router\Template;
use Istok\Router\Tokenizer\TokenizedString;
use Istok\Router\Tokenizer\Tokenizer;

final class HttpTemplate implements Template
{
    private const HOST = 'host';
    private const METHOD = 'method';
    private const PATH = 'path';


    private readonly Tokenizer $tokenizer;
    private readonly TokenizedString $pathTemplate;
    private readonly ?TokenizedString $methodTemplate;
    private readonly ?TokenizedString $hostTemplate;

    public function __construct(
        public readonly string $path,
        public readonly ?string $method = null,
        public readonly ?string $host = null
    ) {
        $this->tokenizer = new Tokenizer();
        $this->pathTemplate = $this->tokenizer->tokenize($this->path, '/');
        $this->methodTemplate = $this->method ? $this->tokenizer->tokenize($this->method) : null;
        $this->hostTemplate = $this->host ? $this->tokenizer->tokenize($this->host, '.', true) : null;
    }

    public function match(Request $request): bool
    {
        return $this->matchHost($request->find(self::HOST))
            && $this->matchMethod($request->find(self::METHOD))
            && $this->matchPath($request->find(self::PATH));
    }

    public function extractArguments(Request $request): array
    {
        return [
            ...$this->extractFromHost($request->find(self::HOST)),
            ...$this->extractFromMethod($request->find(self::METHOD)),
            ...$this->extractFromPath($request->find(self::PATH))
        ];
    }

    private function matchHost(?string $host): bool
    {
        if (!$this->hostTemplate) {
            return true;
        }

        return !is_null($host) && $this->hostTemplate->match($this->tokenizer->tokenize($host, '.', true));
    }

    private function matchMethod(?string $method): bool
    {
        if (!$this->methodTemplate) {
            return true;
        }

        return !is_null($method) && $this->methodTemplate->match($this->tokenizer->tokenize($method));
    }

    private function matchPath(?string $path): bool
    {
        return !is_null($path) && $this->pathTemplate->match($this->tokenizer->tokenize($path, '/'));
    }

    private function extractFromHost(?string $host): array
    {
        if (!$this->hostTemplate || !$host) {
            return [];
        }

        return $this->hostTemplate->extract($this->tokenizer->tokenize($host, '.', true));
    }

    private function extractFromMethod(?string $method): array
    {
        if (!$this->methodTemplate || !$method) {
            return [];
        }

        return $this->methodTemplate->extract($this->tokenizer->tokenize($method));
    }

    private function extractFromPath(?string $path): array
    {
        if (!$path) {
            return [];
        }

        return $this->pathTemplate->extract($this->tokenizer->tokenize($path, '/'));
    }


}
