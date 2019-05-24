<?php
declare(strict_types=1);

namespace PostmanGenerator\Http;

use PostmanGenerator\Interfaces\HttpResponseCodeInterface;

final class ResponseCode implements HttpResponseCodeInterface
{
    /**
     * @var string[]
     */
    private static $messages = [
        100 => 'Continue',
        101 => 'Switching Protocols',
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        306 => '(Unused)',
        307 => 'Temporary Redirect',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Requested Range Not Satisfiable',
        417 => 'Expectation Failed',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported'
    ];

    /**
     * Get status code by message.
     *
     * @param string $message
     *
     * @return int
     */
    public function getCode(string $message): int
    {
        $codes = \array_flip(self::$messages);

        return $codes[$message];
    }

    /**
     * Get status message by code.
     *
     * @param int $code
     *
     * @return string
     */
    public function getMessage(int $code): string
    {
        return self::$messages[$code];
    }

    /**
     * Get response message
     *
     * @param int $code
     *
     * @return string
     */
    public function getResponseMessage(int $code): string
    {
        return $this->isError($code) === false ? 'Successful' : self::$messages[$code];
    }

    /**
     * Is code an error code.
     *
     * @param int $code
     *
     * @return bool
     */
    public function isError(int $code): bool
    {
        return $code >= self::HTTP_BAD_REQUEST;
    }
}
