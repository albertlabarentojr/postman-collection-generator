<?php
declare(strict_types=1);

namespace Tests\PostmanGenerator\Stubs;

use PostmanGenerator\Interfaces\RequestParserInterface;
use PostmanGenerator\Schemas\RequestSchema;

final class RequestParserStub implements RequestParserInterface
{
    /**
     * @var array|mixed[]
     */
    private $data;

    /**
     * RequestParserStub constructor.
     *
     * @param mixed[] $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Parse request from given data.
     *
     * @return \PostmanGenerator\Schemas\RequestSchema
     */
    public function parseRequest(): RequestSchema
    {
        return new RequestSchema($this->data);
    }
}
