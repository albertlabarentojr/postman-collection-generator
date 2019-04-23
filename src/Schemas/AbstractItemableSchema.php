<?php
declare(strict_types=1);

namespace PostmanGenerator\Schemas;

use PostmanGenerator\Interfaces\CollectionSchemaInterface;
use PostmanGenerator\Interfaces\ItemableCollectionInterface;
use PostmanGenerator\Interfaces\ItemSchemaInterface;

/**
 * @method self setItem(CollectionSchemaInterface[] $item)
 */
abstract class AbstractItemableSchema extends AbstractSchema implements ItemableCollectionInterface
{
    /** @var \PostmanGenerator\Interfaces\CollectionSchemaInterface[] */
    protected $item = [];

    /**
     * Add Collection item.
     *
     * @param \PostmanGenerator\Interfaces\ItemSchemaInterface $item
     *
     * @return \PostmanGenerator\Schemas\CollectionSchema
     */
    public function addItem(ItemSchemaInterface $item): AbstractItemableSchema
    {
        $currentPosition = null;

        // Update existing item
        /** @var self|\PostmanGenerator\Schemas\ItemSchema $existingItem */
        /** @var self|\PostmanGenerator\Schemas\ItemSchema $item */
        foreach ($this->item as $index => $existingItem) {
            // Schema must be an item.
            $isItem = $existingItem instanceof ItemSchemaInterface && $item instanceof ItemSchemaInterface;

            if ($isItem && $existingItem->getName() === $item->getName()) {
                $currentPosition = $index;

                // If schema is itemable merge its items.
                /** @noinspection NotOptimalIfConditionsInspection */
                if ($item instanceof ItemableCollectionInterface) {
                    $item->addItems($existingItem->getItem());
                }
            }
        }

        // Insert new item
        if ($currentPosition === null) {
            $currentPosition = \count($this->item);
        }

        $this->item[$currentPosition] = $item;

        return $this;
    }

    /**
     * @param \PostmanGenerator\Interfaces\ItemableCollectionInterface[] $items
     *
     * @return \PostmanGenerator\Interfaces\CollectionSchemaInterface[]
     */
    public function addItems(array $items): array
    {
        foreach ($items as $item) {
            $this->addItem($item);
        }

        return $this->item;
    }

    /**
     * Get items.
     *
     * @return \Countable|CollectionSchemaInterface[]
     */
    public function getItem(): array
    {
        return $this->item;
    }

    /**
     * Get item matched by property.
     *
     * @param string $name
     *
     * @return \PostmanGenerator\Interfaces\CollectionSchemaInterface
     */
    public function getItemByName(string $name): ?CollectionSchemaInterface
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
