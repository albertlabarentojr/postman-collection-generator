<?php
declare(strict_types=1);

namespace PostmanGenerator\Objects;

use PostmanGenerator\Interfaces\CollectionObjectInterface;

/**
 * @method null|string getName()
 * @method self setName(string $name)
 */
class CollectionSubItemObject extends AbstractItemableObject
{
    /** @var string */
    protected $name;

    /**
     * Serialize object as array.
     *
     * @return mixed[]
     */
    public function toArray(): array
    {
        return [
            'name' => $this->getName(),
            'item' => $this->getItem(),
            '_postman_isSubFolder' => true
        ];
    }

    /**
     * Add Collection item.
     *
     * @param \PostmanGenerator\Interfaces\CollectionObjectInterface $item
     *
     * @return \PostmanGenerator\Objects\CollectionObject
     */
    public function addItem(CollectionObjectInterface $item): AbstractItemableObject
    {
        if ($item instanceof ItemObject) {
            /** @var null|\PostmanGenerator\Objects\CollectionItemObject $existingItem */
            $existingItem = $this->getItemByName($item->getName());

            if ($existingItem === null) {
                $this->item[] = $item;
            }
        }

        return $this;
    }
}
