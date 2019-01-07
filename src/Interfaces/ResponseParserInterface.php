<?php
declare(strict_types=1);

namespace PostmanGenerator\Interfaces;

use PostmanGenerator\Objects\ResponseObject;

interface ResponseParserInterface
{
    /**
     * Parse response from given data.
     *
     * @return \PostmanGenerator\Objects\ResponseObject
     */
    public function parseResponse(): ResponseObject;
}
