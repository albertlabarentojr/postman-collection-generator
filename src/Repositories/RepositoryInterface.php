<?php
declare(strict_types=1);

namespace PostmanGenerator\Repositories;

use PostmanGenerator\Interfaces\ItemableCollectionInterface;
use PostmanGenerator\Interfaces\ItemSchemaInterface;

interface RepositoryInterface
{
    /**
     * Find itemable collection schema which has `name` as identifier.
     *
     * @param \PostmanGenerator\Interfaces\ItemableCollectionInterface $schema
     * @param \PostmanGenerator\Interfaces\ItemSchemaInterface $item
     *
     * @return null|\PostmanGenerator\Interfaces\ItemableCollectionInterface
     */
    public function find(ItemableCollectionInterface $schema, ItemSchemaInterface $item): ?ItemableCollectionInterface;
}
