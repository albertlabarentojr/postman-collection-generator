<?php
declare(strict_types=1);

namespace PostmanGenerator\Schemas;

use PostmanGenerator\Interfaces\ItemSchemaInterface;

/**
 * @method null|string getDescription()
 * @method self setName(string $name)
 * @method self setDescription(string $description)
 */
class CollectionItemSchema extends AbstractItemableSchema implements ItemSchemaInterface
{
    /** @var string */
    protected $description;

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
            'description' => $this->getDescription(),
            'item' => $this->getItem()
        ];
    }
}
