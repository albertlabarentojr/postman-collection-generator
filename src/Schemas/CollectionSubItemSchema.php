<?php
declare(strict_types=1);

namespace PostmanGenerator\Schemas;

use PostmanGenerator\Interfaces\ItemSchemaInterface;

/**
 * @method self setName(string $name)
 */
class CollectionSubItemSchema extends AbstractItemableSchema implements ItemSchemaInterface
{
    /** @var string */
    protected $name;

    /**
     * Get schema name identifier.
     *
     * @return null|string
     */
    public function getName(): ?string
    {
        return $this->name;
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
            'item' => $this->getItem(),
            '_postman_isSubFolder' => true
        ];
    }
}
