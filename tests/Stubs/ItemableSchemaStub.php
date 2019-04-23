<?php
declare(strict_types=1);

namespace Tests\PostmanGenerator\Stubs;

use PostmanGenerator\Interfaces\ItemSchemaInterface;
use PostmanGenerator\Schemas\AbstractItemableSchema;

/**
 * @method self setName(string $name)
 */
final class ItemableSchemaStub extends AbstractItemableSchema implements ItemSchemaInterface
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
            'item' => $this->getItem(),
            'name' => $this->getName()
        ];
    }
}
