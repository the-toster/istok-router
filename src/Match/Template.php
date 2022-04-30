<?php

declare(strict_types=1);

namespace Istok\Router\Match;


final class Template
{
    private const DELIMITER = '/';
    /** @var TemplatePart[] */
    private readonly array $parts;
    private readonly int $size;
    private readonly TemplatePart $lastPart;

    public function __construct(
        public readonly string $template
    )
    {
        $normalized = str_replace(' ', self::DELIMITER, $this->template);
        $parts = [];
        foreach (explode(self::DELIMITER, $normalized) as $part) {
            $parts[] = new TemplatePart($part);
        }
        $this->parts = $parts;
        $this->size = count($parts);
        $this->lastPart = $this->parts[$this->size - 1];
    }

    public function match(Request $request): bool
    {

        if($request->size < $this->size) {
            return false;
        }

        foreach ($this->parts as $place => $part) {
            if(!$part->match($request->parts[$place])) {
                return false;
            }
        }

        if($request->size > $this->size) {
            return $this->lastPart->wildcard;
        }

        return true;
    }

    public function extractArguments(Request $request): array
    {
        $r = [];
        foreach ($this->parts as $place => $part) {
            if($part->dynamic) {
                $r[$part->name] = $request->parts[$place];
            }
        }


        if($request->size > $this->size && $this->lastPart->wildcard) {
            $r[$this->lastPart->name] = implode(Request::DELIMITER, [$r[$this->lastPart->name], ...array_slice($request->parts, $this->size)]);
        }

        return $r;
    }
}
