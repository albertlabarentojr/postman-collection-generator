<?php
declare(strict_types=1);

namespace PostmanGenerator\Interfaces;

use PostmanGenerator\Objects\DescriptionObject;

interface CollectionInterface extends FillableCollectionInterface
{
    /**
     * Add collection request.
     *
     * @param string $exampleName
     * @param \PostmanGenerator\Interfaces\RequestParserInterface $request
     *
     * @return \PostmanGenerator\Interfaces\RequestExampleInterface
     */
    public function addRequest(string $exampleName, RequestParserInterface $request): RequestExampleInterface;

    /**
     * Add collection request.
     *
     * @param string $requestName
     *
     * @return \PostmanGenerator\Interfaces\CollectionRequestInterface
     */
    public function addSubCollection(string $requestName): CollectionRequestInterface;

    /**
     * Get collection description.
     *
     * @return string
     */
    public function getDescription(): string;

    /**
     * Set request description.
     *
     * @param \PostmanGenerator\Objects\DescriptionObject $description
     *
     * @return \PostmanGenerator\Interfaces\CollectionInterface
     */
    public function setDescription(DescriptionObject $description): CollectionInterface;
}

