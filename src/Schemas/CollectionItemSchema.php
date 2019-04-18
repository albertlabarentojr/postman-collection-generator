<?php
declare(strict_types=1);

namespace PostmanGenerator\Schemas;

use PostmanGenerator\Interfaces\CollectionSchemaInterface;

/**
 * @method null|string getName()
 * @method null|string getDescription()
 * @method self setName(string $name)
 * @method self setDescription(string $description)
 */
class CollectionItemSchema extends AbstractItemableSchema
{
    /** @var string */
    protected $description;

    /** @var string */
    protected $name;

    /**
     * Add Collection item.
     *
     * @param \PostmanGenerator\Interfaces\CollectionSchemaInterface $item
     *
     * @return \PostmanGenerator\Schemas\CollectionSchema
     */
    public function addItem(CollectionSchemaInterface $item): AbstractItemableSchema
    {
        if ($item instanceof CollectionSubItemSchema || $item instanceof ItemSchema) {
            /** @var null|\PostmanGenerator\Schemas\CollectionItemSchema $existingItem */
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
