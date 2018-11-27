<?php
declare(strict_types=1);

namespace App\Interfaces;

use App\Objects\CollectionSubItemObject;
use App\Objects\RequestObject;
use App\Objects\ResponseObject;

interface RequestExampleInterface
{
    /**
     * Add request example.
     *
     * @param string $exampleName
     * @param \App\Objects\RequestObject $request
     * @param \App\Objects\ResponseObject $response
     *
     * @return \App\Objects\CollectionSubItemObject
     */
    public function addExample(
        string $exampleName,
        RequestObject $request,
        ResponseObject $response
    ): CollectionSubItemObject;
}

