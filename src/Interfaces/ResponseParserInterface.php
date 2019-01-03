<?php
declare(strict_types=1);

namespace PostmanGenerator\Interfaces;

use PostmanGenerator\Objects\ResponseObject;

interface ResponseParserInterface
{
    public function parseResponse(): ResponseObject;
}
