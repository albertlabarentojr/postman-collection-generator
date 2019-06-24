<?php
declare(strict_types=1);

namespace PostmanGenerator\Interfaces;

/**
 * A schema which has an `item`.
 */
interface ItemableCollectionInterface
{
    /**
     * Add items to schema.
     *
     * @param \PostmanGenerator\Interfaces\ItemableCollectionInterface[] $items
     *
     * @return \PostmanGenerator\Interfaces\CollectionSchemaInterface[]
     */
    public function addItems(array $items): array;

    /**
     * Get items.
     *
     * @return \Countable|\PostmanGenerator\Interfaces\CollectionSchemaInterface[]
     */
    public function getItem(): array;
}
