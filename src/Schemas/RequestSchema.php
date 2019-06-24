<?php
declare(strict_types=1);

namespace PostmanGenerator\Schemas;

use PostmanGenerator\Exceptions\InvalidRequestMethodException;

/**
 * @method null|\PostmanGenerator\Schemas\DescriptionSchema getDescription()
 * @method null|string getMethod()
 * @method null|\PostmanGenerator\Schemas\UrlSchema getUrl()
 * @method null|\PostmanGenerator\Schemas\AuthSchema getAuth()
 * @method null|\PostmanGenerator\Schemas\HeaderSchema[] getHeader()
 * @method null|\PostmanGenerator\Schemas\RequestBodySchema getBody()
 * @method self setDescription(\PostmanGenerator\Schemas\DescriptionSchema $description)
 * @method self setUrl(\PostmanGenerator\Schemas\UrlSchema $url)
 * @method self setAuth(\PostmanGenerator\Schemas\AuthSchema $auth)
 * @method self setHeader(\PostmanGenerator\Schemas\HeaderSchema $header)
 * @method self setBody(\PostmanGenerator\Schemas\RequestBodySchema $body)
 */
class RequestSchema extends AbstractSchema
{
    /**
     * Acceptable HTTP Request Methods.
     *
     * @var string[]
     */
    public static $methodTypes = [
        'GET',
        'PUT',
        'POST',
        'PATCH',
        'DELETE',
        'COPY',
        'HEAD',
        'OPTIONS',
        'LINK',
        'UNLINK',
        'PURGE',
        'LOCK',
        'UNLOCK',
        'PROPFIND',
        'VIEW'
    ];

    /** @var \PostmanGenerator\Schemas\AuthSchema */
    protected $auth;

    /** @var \PostmanGenerator\Schemas\RequestBodySchema */
    protected $body;

    /** @var \PostmanGenerator\Schemas\DescriptionSchema */
    protected $description;

    /** @var \PostmanGenerator\Schemas\HeaderSchema[] */
    protected $header = [];

    /** @var string */
    protected $method;

    /** @var \PostmanGenerator\Schemas\UrlSchema */
    protected $url;

    /**
     * Serialize object as array.
     *
     * @return mixed[]
     */
    public function toArray(): array
    {
        return [
            'auth' => $this->getAuth(),
            'body' => $this->getBody(),
            'description' => $this->getDescription(),
            'header' => $this->getHeader(),
            'method' => $this->getMethod(),
            'url' => $this->getUrl()
        ];
    }

    /**
     * Set http request method.
     *
     * @param string $method
     *
     * @return \PostmanGenerator\Schemas\RequestSchema
     *
     * @throws \PostmanGenerator\Exceptions\InvalidRequestMethodException
     */
    public function setMethod(string $method): self
    {
        if (\in_array($method, self::$methodTypes, true) === false) {
            throw new InvalidRequestMethodException(\sprintf('Invalid Request method type: [%s]', $method));
        }

        $this->method = $method;

        return $this;
    }
}
