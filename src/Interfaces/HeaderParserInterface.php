<?php
declare(strict_types=1);

namespace PostmanGenerator\Interfaces;

interface HeaderParserInterface
{
    /**
     * Parse key-value headers and create HeaderSchema for each.
     *
     * @param mixed[] $headers
     *
     * @return \PostmanGenerator\Schemas\HeaderSchema[]
     */
    public function parse(array $headers): array;
}
