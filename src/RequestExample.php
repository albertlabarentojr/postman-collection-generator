<?php
declare(strict_types=1);

namespace App;

use App\Interfaces\RequestExampleInterface;
use App\Interfaces\RequestParserInterface;
use App\Interfaces\ResponseParserInterface;
use App\Objects\ItemObject;
use App\Objects\RequestObject;

class RequestExample implements RequestExampleInterface
{
    /**
     * @var \App\Objects\ItemObject
     */
    private $itemObject;

    /** @var \App\Objects\RequestObject */
    private $originalRequest;

    /**
     * RequestExample constructor.
     *
     * @param \App\Objects\ItemObject $itemObject
     * @param \App\Interfaces\RequestParserInterface $request
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
     * @param \App\Interfaces\RequestParserInterface $requestParser
     * @param \App\Interfaces\ResponseParserInterface $responseParser
     *
     * @return \App\Interfaces\RequestExampleInterface
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
     * @param \App\Objects\RequestObject $request
     *
     * @return \App\RequestExample
     */
    public function setOriginalRequest(RequestObject $request): RequestExample
    {
        $this->itemObject->setRequest($request);

        return $this;
    }
}
