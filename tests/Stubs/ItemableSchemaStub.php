<?php
declare(strict_types=1);

namespace Tests\PostmanGenerator\Stubs;

use PostmanGenerator\Schemas\AbstractItemableSchema;

/**
 * @method null|string getName()
 * @method self setName(string $name)
 */
final class ItemableSchemaStub extends AbstractItemableSchema
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
            'item' => $this->getItem(),
            'name' => $this->getName()
        ];
    }
}
