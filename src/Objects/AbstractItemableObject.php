<?php
declare(strict_types=1);

namespace PostmanGenerator\Objects;

use PostmanGenerator\Interfaces\CollectionObjectInterface;
use PostmanGenerator\Interfaces\ItemableCollectionInterface;

/**
 * @method \Countable|CollectionObjectInterface[] getItem()
 * @method self setItem(CollectionObjectInterface[] $item);
 */
abstract class AbstractItemableObject extends AbstractDataObject implements ItemableCollectionInterface
{
    /** @var \PostmanGenerator\Interfaces\CollectionObjectInterface[] */
    protected $item = [];

    /**
     * Add Collection item.
     *
     * @param \PostmanGenerator\Interfaces\CollectionObjectInterface $item
     *
     * @return \PostmanGenerator\Objects\CollectionObject
     */
    public function addItem(CollectionObjectInterface $item): self
    {
        $this->item[] = $item;

        return $this;
    }

    /**
     * @param \PostmanGenerator\Interfaces\ItemableCollectionInterface[] $items
     *
     * @return \PostmanGenerator\Interfaces\CollectionObjectInterface[]
     */
    public function addItems(array $items): array
    {
        foreach ($items as $item) {
            $this->addItem($item);
        }

        return $this->item;
    }

    /**
     * Get item matched by property.
     *
     * @param string $name
     *
     * @return \PostmanGenerator\Interfaces\CollectionObjectInterface
     */
    public function getItemByName(string $name): ?CollectionObjectInterface
    {
        /** @var mixed $item */
        foreach ($this->item as $item) {
            if ($item->getName() === $name) {
                return $item;
            }
        }

        return null;
    }
}
