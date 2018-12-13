<?php
declare(strict_types=1);

namespace App\Interfaces;

use App\Objects\RequestObject;
use App\RequestExample;

interface RequestExampleInterface
{
    /**
     * Add request example.
     *
     * @param string $exampleName
     * @param \App\Interfaces\RequestParserInterface $request
     *
     * @param \App\Interfaces\ResponseParserInterface $response
     *
     * @return \App\Interfaces\RequestExampleInterface
     */
    public function addExample(
        string $exampleName,
        RequestParserInterface $request,
        ResponseParserInterface $response
    ): RequestExampleInterface;

    /**
     * Set example original request.
     *
     * @param \App\Objects\RequestObject $request
     *
     * @return \App\RequestExample
     */
    public function setOriginalRequest(RequestObject $request): RequestExample;
}
