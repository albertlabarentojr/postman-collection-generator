<?php
declare(strict_types=1);

namespace PostmanGenerator\Interfaces;

use PostmanGenerator\Objects\RequestObject;
use PostmanGenerator\RequestExample;

interface RequestExampleInterface
{
    /**
     * Add request example.
     *
     * @param string $exampleName
     * @param \PostmanGenerator\Interfaces\RequestParserInterface $request
     *
     * @param \PostmanGenerator\Interfaces\ResponseParserInterface $response
     *
     * @return \PostmanGenerator\Interfaces\RequestExampleInterface
     */
    public function addExample(
        string $exampleName,
        RequestParserInterface $request,
        ResponseParserInterface $response
    ): RequestExampleInterface;

    /**
     * Set example original request.
     *
     * @param \PostmanGenerator\Objects\RequestObject $request
     *
     * @return \PostmanGenerator\RequestExample
     */
    public function setOriginalRequest(RequestObject $request): RequestExample;
}
