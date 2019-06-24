<?php
declare(strict_types=1);

namespace PostmanGenerator;

use PostmanGenerator\Interfaces\RequestExampleInterface;
use PostmanGenerator\Interfaces\RequestParserInterface;
use PostmanGenerator\Interfaces\ResponseParserInterface;
use PostmanGenerator\Schemas\ItemSchema;
use PostmanGenerator\Schemas\RequestSchema;

class RequestExample implements RequestExampleInterface
{
    /**
     * @var \PostmanGenerator\Schemas\ItemSchema
     */
    private $itemObject;

    /** @var \PostmanGenerator\Schemas\RequestSchema */
    private $originalRequest;

    /**
     * RequestExample constructor.
     *
     * @param \PostmanGenerator\Schemas\ItemSchema $itemObject
     * @param \PostmanGenerator\Interfaces\RequestParserInterface $request
     */
    public function __construct(ItemSchema $itemObject, RequestParserInterface $request)
    {
        $this->itemObject = $itemObject;
        $this->originalRequest = $request->parse();
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
        $this->itemObject->setRequest($requestParser->parse());

        $response = $responseParser->parse();
        $response->fill(['name' => $exampleName]);
        $response->setOriginalRequest($this->originalRequest);

        $this->itemObject->addResponse($response);

        return $this;
    }

    /**
     * Set example original request.
     *
     * @param \PostmanGenerator\Schemas\RequestSchema $request
     *
     * @return \PostmanGenerator\RequestExample
     */
    public function setOriginalRequest(RequestSchema $request): RequestExample
    {
        $this->itemObject->setRequest($request);

        return $this;
    }
}
