<?php
declare(strict_types=1);

namespace App\Interfaces;

interface CollectionRequestInterface extends FillableCollectionInterface
{
    /**
     * Add request example.
     *
     * @param string $exampleName
     * @param \App\Interfaces\RequestParserInterface $request
     *
     * @return \App\Interfaces\RequestExampleInterface
     */
    public function addRequest(string $exampleName, RequestParserInterface $request): RequestExampleInterface;
}
