<?php
declare(strict_types=1);

namespace PostmanGenerator\Objects;

/**
 * @method null|string getContentType()
 * @method null|DescriptionObject getDescription()
 * @method null|bool isDisabled()
 * @method null|string getKey()
 * @method null|string getType()
 * @method null|string getValue()
 * @method self setContentType(string $contentType)
 * @method self setDescription(DescriptionObject $descriptionObject)
 * @method self setDisabled(bool $disabled)
 * @method self setKey(string $key)
 * @method self setType(string $type)
 * @method self setValue(string $value)
 */
class FormParameterObject extends AbstractDataObject
{
    /** @var string */
    protected $contentType;

    /** @var \PostmanGenerator\Objects\DescriptionObject */
    protected $description;

    /** @var bool */
    protected $disabled;

    /** @var string */
    protected $key;

    /** @var string */
    protected $type;

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
            'content_type' => $this->getContentType(),
            'description' => $this->getDescription(),
            'disabled' => $this->isDisabled(),
            'key' => $this->getKey(),
            'type' => $this->getType(),
            'value' => $this->getValue()
        ];
    }
}
