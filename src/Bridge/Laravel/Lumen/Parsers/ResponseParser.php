<?php
declare(strict_types=1);

namespace PostmanGenerator\Bridge\Laravel\Lumen\Parsers;

use Illuminate\Http\Response;
use PostmanGenerator\Interfaces\ResponseParserInterface;
use PostmanGenerator\Schemas\ResponseSchema;

final class ResponseParser implements ResponseParserInterface
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
    public function parse(): ResponseSchema
    {
        return new ResponseSchema([
            'body' => $this->response->getContent(),
            'code' => $this->response->getStatusCode(),
            'name' => $this->name
        ]);
    }
}
