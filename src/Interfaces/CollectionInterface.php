<?php
declare(strict_types=1);

namespace App\Interfaces;

use App\Objects\DescriptionObject;

interface CollectionInterface extends FillableCollectionInterface
{
    /**
     * Add collection request.
     *
     * @param string $exampleName
     * @param \App\Interfaces\RequestParserInterface $request
     *
     * @return \App\Interfaces\RequestExampleInterface
     */
    public function addRequest(string $exampleName, RequestParserInterface $request): RequestExampleInterface;

    /**
     * Add collection request.
     *
     * @param string $requestName
     *
     * @return \App\Interfaces\CollectionRequestInterface
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
     * @param \App\Objects\DescriptionObject $description
     *
     * @return \App\Interfaces\CollectionInterface
     */
    public function setDescription(DescriptionObject $description): CollectionInterface;
}

