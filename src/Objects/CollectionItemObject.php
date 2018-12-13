<?php
declare(strict_types=1);

namespace App\Objects;

/**
 * @method null|string getName()
 * @method null|string getDescription()
 * @method CollectionSubItemObject[] getItem()
 * @method self setName(string $name)
 * @method self setDescription(string $description)
 * @method self setItem(CollectionSubItemObject[] $collectionSubItems)
 */
class CollectionItemObject extends AbstractDataObject
{
    /** @var string */
    protected $description;

    /** @var \App\Objects\CollectionSubItemObject[] */
    protected $item = [];

    /** @var string */
    protected $name;

    /**
     * Add sub item to collection item.
     *
     * @param \App\Objects\ItemObject|\App\Objects\CollectionSubItemObject $collectionSubItem
     *
     * @return \App\Objects\CollectionItemObject
     */
    public function addItem($collectionSubItem): self
    {
        $this->item[] = $collectionSubItem;

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
