<?php
declare(strict_types=1);

namespace PostmanGenerator\Schemas;

use PostmanGenerator\Interfaces\PrePopulateInterface;

/**
 * @method null|string getVariableId()
 * @method null|string getKey()
 * @method null|mixed getValue()
 * @method null|string getType()
 * @method null|string getName()
 * @method null|\PostmanGenerator\Schemas\DescriptionSchema getDescription()
 * @method bool isSystem()
 * @method bool isDisabled()
 * @method self setKey(string $key)
 * @method self setValue(string $value)
 * @method self setType(string $type)
 * @method self setName(string $name)
 * @method self setDescription(\PostmanGenerator\Schemas\DescriptionSchema $description)
 * @method self setSystem(bool $isSystem)
 * @method self setDisabled(bool $isDisabled)
 */
class VariableSchema extends AbstractSchema implements PrePopulateInterface
{
    /** @var string */
    public const ID_PREFIX = 'variable_';

    /** @var \PostmanGenerator\Schemas\DescriptionSchema */
    protected $description;

    /** @var bool */
    protected $disabled = false;

    /** @var string */
    protected $key;

    /** @var string */
    protected $name;

    /** @var bool */
    protected $system = false;

    /** @var string */
    protected $type;

    /** @var mixed */
    protected $value;

    /** @var string */
    protected $variableId;

    /**
     * Serialize object as array.
     *
     * @return mixed[]
     */
    public function toArray(): array
    {
        return [
            'description' => $this->getDescription(),
            'disabled' => $this->isDisabled(),
            'id' => $this->getVariableId(),
            'key' => $this->getKey(),
            'name' => $this->getName(),
            'system' => $this->isSystem(),
            'type' => $this->getType(),
            'value' => $this->getValue()
        ];
    }

    /**
     * Fill properties before mass assignment.
     *
     * @return void
     */
    public function beforeFill(): void
    {
        $this->variableId = $this->generateId(self::ID_PREFIX);
    }
}
