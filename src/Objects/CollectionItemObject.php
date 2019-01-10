<?php
declare(strict_types=1);

namespace PostmanGenerator\Objects;

use PostmanGenerator\Interfaces\CollectionObjectInterface;

/**
 * @method null|string getName()
 * @method null|string getDescription()
 * @method self setName(string $name)
 * @method self setDescription(string $description)
 */
class CollectionItemObject extends AbstractItemableObject
{
    /** @var string */
    protected $description;

    /** @var string */
    protected $name;

    /**
     * Add Collection item.
     *
     * @param \PostmanGenerator\Interfaces\CollectionObjectInterface $item
     *
     * @return \PostmanGenerator\Objects\CollectionObject
     */
    public function addItem(CollectionObjectInterface $item): AbstractItemableObject
    {
        if ($item instanceof CollectionSubItemObject || $item instanceof ItemObject) {
            /** @var null|\PostmanGenerator\Objects\CollectionItemObject $existingItem */
            $existingItem = $this->getItemByName($item->getName());

            if ($existingItem !== null) {
                // Merge items to existing collection item in collection.
                $existingItem->addItems($item->getItem());

                return $this;
            }

            $this->item[] = $item;
        }

        return $this;
    }

    /**
     * Serialize object as array.
     *
     * @return mixed[]
     */
    public function toArray(): array
    {
        return [
            'name' => $this->getName(),
            'description' => $this->getDescription(),
            'item' => $this->getItem()
        ];
    }
}
