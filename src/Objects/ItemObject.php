<?php
declare(strict_types=1);

namespace PostmanGenerator\Objects;

/**
 * @method null|string getName()
 * @method null|RequestObject getRequest()
 * @method ResponseObject[] getResponse()
 * @method self setName(string $name)
 * @method self setRequest(RequestObject $request)
 * @method self setResponse(ResponseObject[] $responses)
 */
class ItemObject extends AbstractDataObject
{
    /** @var string */
    protected $name;

    /** @var \PostmanGenerator\Objects\RequestObject */
    protected $request;

    /** @var \PostmanGenerator\Objects\ResponseObject[] */
    protected $response = [];

    /**
     * Add response.
     *
     * @param \PostmanGenerator\Objects\ResponseObject $response
     *
     * @return \PostmanGenerator\Objects\ItemObject
     */
    public function addResponse(ResponseObject $response): self
    {
        $this->response[] = $response;

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
            'name' => $this->getName(),
            'request' => $this->getRequest(),
            'response' => $this->getResponse()
        ];
    }
}
