<?php
declare(strict_types=1);

namespace App\Objects;

use App\Interfaces\PrePopulateInterface;

/**
 * @method null|string getResponseId()
 * @method null|string getName()
 * @method null|RequestObject getOriginalRequest()
 * @method null|string|int getResponseTime()
 * @method HeaderObject[] getHeader()
 * @method mixed[] getBody()
 * @method null|string getStatus()
 * @method null|int getCode()
 * @method self setResponseTime($responseTime)
 * @method self setName(string $name)
 * @method self setHeader(array $headers)
 * @method self setBody(array $body)
 * @method self setStatus(string $status)
 * @method self setCode(int $code)
 * @method self setOriginalRequest(RequestObject $request)
 */
class ResponseObject extends AbstractDataObject implements PrePopulateInterface
{
    private const ID_PREFIX = 'response_';

    /** @var string */
    public const PREVIEW_FORMAT = 'json';

    /** @var mixed[] */
    protected $body;

    /** @var int */
    protected $code;

    /** @var HeaderObject[] */
    protected $header = [];

    /** @var string */
    protected $name;

    /** @var \App\Objects\RequestObject */
    protected $originalRequest;

    /** @var string */
    protected $responseId;

    /** @var mixed */
    protected $responseTime;

    /** @var string */
    protected $status;

    /**
     * Fill properties before mass assignment.
     *
     * @return void
     */
    public function beforeFill(): void
    {
        $this->responseId = $this->responseId ?? \uniqid(self::ID_PREFIX, true);
    }

    /**
     * Serialize object as array.
     *
     * @return mixed[]
     */
    public function toArray(): array
    {
        return [
            'id' => $this->getResponseId(),
            'originalRequest' => $this->getOriginalRequest(),
            'responseTime' => $this->getResponseTime(),
            'header' => $this->getHeader(),
            'body' => \json_encode($this->getBody()),
            'status' => $this->getStatus(),
            'code' => $this->getCode(),
            'name' => $this->getName(),
            '_postman_previewlanguage' => self::PREVIEW_FORMAT
        ];
    }
}
