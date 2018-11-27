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
    /**
     * @var string
     */
    protected $content;

    /**
     * @var string
     */
    protected $type = 'text/markdown';

    /** @inheritdoc */
    public function toArray(): array
    {
        return ['content' => $this->getContent(), 'type' => $this->getType()];
    }
}
