<?php
declare(strict_types=1);

namespace PostmanGenerator\Schemas;

/**
 * @method null|string getSource()
 * @method null|string getContent()
 * @method self setSource(string $source)
 * @method self setContent(string $content)
 */
class FileSchema extends AbstractSchema
{
    /** @var string */
    protected $source;

    /** @var string */
    protected $content;

    /**
     * Serialize object as array.
     *
     * @return mixed[]
     */
    public function toArray(): array
    {
        return ['content' => $this->getContent(), 'src' => $this->getSource()];
    }
}
