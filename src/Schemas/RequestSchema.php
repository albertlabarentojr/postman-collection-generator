<?php
declare(strict_types=1);

namespace PostmanGenerator\Schemas;

use PostmanGenerator\Exceptions\InvalidRequestMethodException;

/**
 * @method null|DescriptionSchema getDescription()
 * @method null|string getMethod()
 * @method null|UrlSchema getUrl()
 * @method null|AuthSchema getAuth()
 * @method null|HeaderSchema getHeader()
 * @method null|RequestBodySchema getBody()
 * @method self setDescription(DescriptionSchema $description)
 * @method self setUrl(UrlSchema $url)
 * @method self setAuth(AuthSchema $auth)
 * @method self setHeader(HeaderSchema $header)
 * @method self setBody(RequestBodySchema $body)
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

    /** @var \PostmanGenerator\Schemas\HeaderSchema */
    protected $header;

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
        if(\in_array($method, self::$methodTypes, true) === false){
            throw new InvalidRequestMethodException(\sprintf('Invalid Request method type: [%s]', $method));
        }

        $this->method = $method;

        return $this;
    }
}
