<?php
declare(strict_types=1);

namespace PostmanGenerator\Interfaces;

use PostmanGenerator\Schemas\ResponseSchema;

interface ResponseParserInterface
{
    /**
     * Parse response from given data.
     *
     * @return \PostmanGenerator\Schemas\ResponseSchema
     */
    public function parseResponse(): ResponseSchema;
}
