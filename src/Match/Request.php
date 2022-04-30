<?php

declare(strict_types=1);

namespace Istok\Router\Match;


final class Request
{
    public const DELIMITER = '/';

    /** @var string[] */
    public readonly array $parts;
    public readonly int $size;

    public function __construct(
        public readonly string $request
    )
    {
        $normalized = str_replace(' ', self::DELIMITER, $this->request);
        $this->parts = explode(self::DELIMITER, $normalized);
        $this->size = count($this->parts);
    }

}
