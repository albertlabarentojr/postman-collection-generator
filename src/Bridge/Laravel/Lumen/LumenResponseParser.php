<?php
declare(strict_types=1);

namespace PostmanGenerator\Bridge\Laravel\Lumen;

use Illuminate\Http\Response;
use PostmanGenerator\Interfaces\ResponseParserInterface;
use PostmanGenerator\Schemas\RequestSchema;
use PostmanGenerator\Schemas\ResponseSchema;

final class LumenResponseParser implements ResponseParserInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var \Illuminate\Http\Response
     */
    private $response;

    /**
     * LumenResponseParser constructor.
     *
     * @param \Illuminate\Http\Response $response
     * @param string $name
     */
    public function __construct(Response $response, string $name)
    {
        $this->response = $response;
        $this->name = $name;
    }

    /**
     * Parse response from given data.
     *
     * @return \PostmanGenerator\Schemas\ResponseSchema
     */
    public function parseResponse(): ResponseSchema
    {
        return new ResponseSchema([
            'body' => \json_decode($this->response->getContent(), true),
            'code' => $this->response->getStatusCode(),
            'name' => $this->name
        ]);
    }
}
