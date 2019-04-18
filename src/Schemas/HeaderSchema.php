<?php
declare(strict_types=1);

namespace PostmanGenerator\Schemas;

/**
 * @method DescriptionSchema getDescription()
 * @method bool isDisabled()
 * @method string getKey()
 * @method string getValue()
 * @method self setDescription(DescriptionSchema $descriptionObject)
 * @method self setDisabled(bool $disabled)
 * @method self setValue(string $value)
 * @method self setKey(string $key)
 */
class HeaderSchema extends AbstractSchema
{
    /** @var \PostmanGenerator\Schemas\DescriptionSchema */
    protected $description;

    /** @var bool */
    protected $disabled;

    /** @var string */
    protected $key;

    /** @var string */
    protected $value;

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
            'key' => $this->getKey(),
            'value' => $this->getValue(),
            'name' => $this->getKey()
        ];
    }
}
