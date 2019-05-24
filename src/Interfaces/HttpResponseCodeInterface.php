<?php
declare(strict_types=1);

namespace PostmanGenerator\Interfaces;

interface HttpResponseCodeInterface
{
    // [Informational 1xx]
    public const HTTP_ACCEPTED = 202;

    public const HTTP_BAD_GATEWAY = 502;

    // [Successful 2xx]

    public const HTTP_BAD_REQUEST = 400;

    public const HTTP_CONFLICT = 409;

    public const HTTP_CONTINUE = 100;

    public const HTTP_CREATED = 201;

    public const HTTP_EXPECTATION_FAILED = 417;

    public const HTTP_FORBIDDEN = 403;

    public const HTTP_FOUND = 302;

    // [Redirection 3xx]

    public const HTTP_GATEWAY_TIMEOUT = 504;

    public const HTTP_GONE = 410;

    public const HTTP_INTERNAL_SERVER_ERROR = 500;

    public const HTTP_LENGTH_REQUIRED = 411;

    public const HTTP_METHOD_NOT_ALLOWED = 405;

    public const HTTP_MOVED_PERMANENTLY = 301;

    public const HTTP_MULTIPLE_CHOICES = 300;

    public const HTTP_NONAUTHORITATIVE_INFORMATION = 203;

    // [Client Error 4xx]

    public const HTTP_NOT_ACCEPTABLE = 406;

    public const HTTP_NOT_FOUND = 404;

    public const HTTP_NOT_IMPLEMENTED = 501;

    public const HTTP_NOT_MODIFIED = 304;

    public const HTTP_NO_CONTENT = 204;

    public const HTTP_OK = 200;

    public const HTTP_PARTIAL_CONTENT = 206;

    public const HTTP_PAYMENT_REQUIRED = 402;

    public const HTTP_PRECONDITION_FAILED = 412;

    public const HTTP_PROXY_AUTHENTICATION_REQUIRED = 407;

    public const HTTP_REQUESTED_RANGE_NOT_SATISFIABLE = 416;

    public const HTTP_REQUEST_ENTITY_TOO_LARGE = 413;

    public const HTTP_REQUEST_TIMEOUT = 408;

    public const HTTP_REQUEST_URI_TOO_LONG = 414;

    public const HTTP_RESET_CONTENT = 205;

    public const HTTP_SEE_OTHER = 303;

    public const HTTP_SERVICE_UNAVAILABLE = 503;

    public const HTTP_SWITCHING_PROTOCOLS = 101;

    public const HTTP_TEMPORARY_REDIRECT = 307;

    // [Server Error 5xx]

    public const HTTP_UNAUTHORIZED = 401;

    public const HTTP_UNSUPPORTED_MEDIA_TYPE = 415;

    public const HTTP_UNUSED = 306;

    public const HTTP_USE_PROXY = 305;

    public const HTTP_VERSION_NOT_SUPPORTED = 505;

    /**
     * Get status code by message.
     *
     * @param string $message
     *
     * @return int
     */
    public function getCode(string $message): int;

    /**
     * Get status message by code.
     *
     * @param int $code
     *
     * @return string
     */
    public function getMessage(int $code): string;

    /**
     * Get response message
     *
     * @param int $code
     *
     * @return string
     */
    public function getResponseMessage(int $code): string;

    /**
     * Is code an error code.
     *
     * @param int $code
     *
     * @return bool
     */
    public function isError(int $code): bool;
}
