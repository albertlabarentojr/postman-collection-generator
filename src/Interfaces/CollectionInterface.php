<?php
declare(strict_types=1);

namespace PostmanGenerator\Interfaces;

interface CollectionInterface extends FillableCollectionInterface
{
    /**
     * Add collection request.
     *
     * @param string $requestName
     * @param \PostmanGenerator\Interfaces\RequestParserInterface $request
     *
     * @return \PostmanGenerator\Interfaces\RequestExampleInterface
     */
    public function addRequest(string $requestName, RequestParserInterface $request): RequestExampleInterface;

    /**
     * Add collection request.
     *
     * @param string $requestName
     *
     * @return \PostmanGenerator\Interfaces\CollectionInterface
     */
    public function addSubCollection(string $requestName): self;
}
