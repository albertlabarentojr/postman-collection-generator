<?php
declare(strict_types=1);

namespace PostmanGenerator\Objects;

use PostmanGenerator\Interfaces\PrePopulateInterface;

/**
 * @method null|string getName()
 * @method null|string getDescription()
 * @method null|string getSchema()
 * @method string getPostmanId()
 * @method self setName(string $name)
 * @method self setDescription(string $description)
 * @method self setSchema(string $schema)
 * @method self setPostmanId(string $id)
 */
class InfoObject extends AbstractDataObject implements PrePopulateInterface
{
    /** @var string */
    protected $description;

    /** @var string */
    protected $name;

    /** @var string */
    protected $postmanId;

    /** @var string */
    protected $schema = 'https://schema.getpostman.com/json/collection/v2.0.0/docs/index.html';

    /**
     * Fill properties before mass assignment.
     *
     * @return void
     */
    public function beforeFill(): void
    {
        $this->postmanId = $this->generateId('postman_collection');
    }

    /**
     * Set postman info id.
     *
     * @param string $postmanId
     *
     * @return \PostmanGenerator\Objects\InfoObject
     */
    public function setInfoId(string $postmanId): self
    {
        $this->setPostmanId($postmanId);

        return $this;
    }

    /**
     * Serialize object as array.
     *
     * @return mixed[]
     */
    public function toArray(): array
    {
        return [
            '_postman_id' => $this->getPostmanId(),
            'name' => $this->getName(),
            'description' => $this->getDescription(),
            'schema' => $this->getSchema()
        ];
    }
}
