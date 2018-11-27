<?php
declare(strict_types=1);

namespace App\Interfaces;

use App\Objects\RequestObject;
use App\Objects\ResponseObject;

interface CollectionRequestInterface
{
    /**
     * Add collection request.
     *
     * @param string $requestName
     * @param \App\Objects\RequestObject|null $request
     * @param \App\Objects\ResponseObject|null $response
     *
     * @return \App\Interfaces\RequestExampleInterface
     */
    public function addRequest(
        string $requestName,
        ?RequestObject $request,
        ?ResponseObject $response
    ): RequestExampleInterface;

    /**
     * Get request name.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Set request description
     *
     * @return \App\Interfaces\RequestExampleInterface
     */
    public function setDescription(): RequestExampleInterface;

    /**
     * Get request description.
     *
     * @return string
     */
    public function getDescription(): string;
}
