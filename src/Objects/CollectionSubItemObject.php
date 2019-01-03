<?php
declare(strict_types=1);

namespace PostmanGenerator\Objects;

/**
 * @method null|string getName()
 * @method ItemObject[] getItem()
 * @method self setName(string $name)
 * @method self setItem(ItemObject $item)
 */
class CollectionSubItemObject extends AbstractDataObject
{
    /** @var string */
    protected $name;

    /** @var \PostmanGenerator\Objects\ItemObject[] */
    protected $item = [];

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
     * Add sub collection item.
     *
     * @param \PostmanGenerator\Objects\ItemObject $item
     *
     * @return \PostmanGenerator\Objects\CollectionSubItemObject
     */
    public function addItem(ItemObject $item): self
    {
        $this->item[] = $item;

        return $this;
    }
}
