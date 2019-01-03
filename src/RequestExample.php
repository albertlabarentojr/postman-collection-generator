<?php
declare(strict_types=1);

namespace PostmanGenerator;

use PostmanGenerator\Interfaces\RequestExampleInterface;
use PostmanGenerator\Interfaces\RequestParserInterface;
use PostmanGenerator\Interfaces\ResponseParserInterface;
use PostmanGenerator\Objects\ItemObject;
use PostmanGenerator\Objects\RequestObject;

class RequestExample implements RequestExampleInterface
{
    /**
     * @var \PostmanGenerator\Objects\ItemObject
     */
    private $itemObject;

    /** @var \PostmanGenerator\Objects\RequestObject */
    private $originalRequest;

    /**
     * RequestExample constructor.
     *
     * @param \PostmanGenerator\Objects\ItemObject $itemObject
     * @param \PostmanGenerator\Interfaces\RequestParserInterface $request
     */
    public function __construct(ItemObject $itemObject, RequestParserInterface $request)
    {
        $this->itemObject = $itemObject;
        $this->originalRequest = $request->parseRequest();
    }

    /**
     * Add request example.
     *
     * @param string $exampleName
     * @param \PostmanGenerator\Interfaces\RequestParserInterface $requestParser
     * @param \PostmanGenerator\Interfaces\ResponseParserInterface $responseParser
     *
     * @return \PostmanGenerator\Interfaces\RequestExampleInterface
     */
    public function addExample(
        string $exampleName,
        RequestParserInterface $requestParser,
        ResponseParserInterface $responseParser
    ): RequestExampleInterface {
        $this->itemObject->setRequest($requestParser->parseRequest());

        $response = $responseParser->parseResponse();
        $response->fill(['name' => $exampleName]);
        $response->setOriginalRequest($this->originalRequest);

        $this->itemObject->addResponse($response);

        return $this;
    }

    /**
     * Set example original request.
     *
     * @param \PostmanGenerator\Objects\RequestObject $request
     *
     * @return \PostmanGenerator\RequestExample
     */
    public function setOriginalRequest(RequestObject $request): RequestExample
    {
        $this->itemObject->setRequest($request);

        return $this;
    }
}
