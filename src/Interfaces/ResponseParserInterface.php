<?php
declare(strict_types=1);

namespace App\Interfaces;

use App\Objects\ResponseObject;

interface ResponseParserInterface
{
    public function parseResponse(): ResponseObject;
}
