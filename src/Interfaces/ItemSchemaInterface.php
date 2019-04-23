<?php
declare(strict_types=1);

namespace PostmanGenerator\Interfaces;

/**
 * A schema which has a `name` as identifier.
 */
interface ItemSchemaInterface
{
    /**
     * Get schema name identifier.
     *
     * @return null|string
     */
    public function getName(): ?string;
}
