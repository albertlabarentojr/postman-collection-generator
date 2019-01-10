<?php
declare(strict_types=1);

namespace PostmanGenerator\Interfaces;

interface ItemableCollectionInterface
{
    /**
     * @param \PostmanGenerator\Interfaces\ItemableCollectionInterface[] $items
     *
     * @return \PostmanGenerator\Interfaces\CollectionObjectInterface[]
     */
    public function addItems(array $items): array;
}
