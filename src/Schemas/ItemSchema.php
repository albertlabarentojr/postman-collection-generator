<?php
declare(strict_types=1);

namespace PostmanGenerator\Schemas;

use PostmanGenerator\Interfaces\ItemSchemaInterface;

/**
 * @method null|RequestSchema getRequest()
 * @method ResponseSchema[] getResponse()
 * @method self setName(string $name)
 * @method self setRequest(RequestSchema $request)
 * @method self setResponse(ResponseSchema[] $responses)
 */
class ItemSchema extends AbstractItemableSchema implements ItemSchemaInterface
{
    /** @var string */
    protected $name;

    /** @var \PostmanGenerator\Schemas\RequestSchema */
    protected $request;

    /** @var \PostmanGenerator\Schemas\ResponseSchema[] */
    protected $response = [];

    /**
     * Add response.
     *
     * @param \PostmanGenerator\Schemas\ResponseSchema $response
     *
     * @return \PostmanGenerator\Schemas\ItemSchema
     */
    public function addResponse(ResponseSchema $response): self
    {
        $this->addItems([$response]);

        $this->response = $this->getItem();

        return $this;
    }

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
            'name' => $this->getName(),
            'request' => $this->getRequest(),
            'response' => $this->getResponse()
        ];
    }
}
