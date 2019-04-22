<?php
declare(strict_types=1);

namespace PostmanGenerator\Schemas;

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
