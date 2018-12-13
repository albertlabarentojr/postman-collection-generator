<?php
declare(strict_types=1);

namespace App\Objects;

/**
 * @method null|string getContent()
 * @method null|string getType()
 * @method self setContent(string $content)
 * @method self setType(string $type)
 */
class DescriptionObject extends AbstractDataObject
{
    public const DEFAULT_TYPE = 'text/markdown';

    /**
     * @var string
     */
    protected $content;

    /**
     * @var string
     */
    protected $type = self::DEFAULT_TYPE;

    /** @inheritdoc */
    public function toArray(): array
    {
        return ['content' => $this->getContent(), 'type' => $this->getType()];
    }
}
