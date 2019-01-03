<?php
declare(strict_types=1);

namespace PostmanGenerator\Interfaces;

interface CollectionRequestInterface extends FillableCollectionInterface
{
    /**
     * Add request example.
     *
     * @param string $exampleName
     * @param \PostmanGenerator\Interfaces\RequestParserInterface $request
     *
     * @return \PostmanGenerator\Interfaces\RequestExampleInterface
     */
    public function addRequest(string $exampleName, RequestParserInterface $request): RequestExampleInterface;
}
