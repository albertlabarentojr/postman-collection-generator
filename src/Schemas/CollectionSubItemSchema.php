<?php
declare(strict_types=1);

namespace PostmanGenerator\Schemas;

use PostmanGenerator\Interfaces\CollectionSchemaInterface;

/**
 * @method null|string getName()
 * @method self setName(string $name)
 */
class CollectionSubItemSchema extends AbstractItemableSchema
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
     * @param \PostmanGenerator\Interfaces\CollectionSchemaInterface $item
     *
     * @return \PostmanGenerator\Schemas\CollectionSchema
     */
    public function addItem(CollectionSchemaInterface $item): AbstractItemableSchema
    {
        if ($item instanceof ItemSchema) {
            /** @var null|\PostmanGenerator\Schemas\CollectionItemSchema $existingItem */
            $existingItem = $this->getItemByName($item->getName());

            if ($existingItem === null) {
                $this->item[] = $item;
            }
        }

        return $this;
    }
}
