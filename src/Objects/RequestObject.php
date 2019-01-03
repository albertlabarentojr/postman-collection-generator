<?php
declare(strict_types=1);

namespace PostmanGenerator\Objects;

use PostmanGenerator\Exceptions\InvalidRequestMethodException;

/**
 * @method null|DescriptionObject getDescription()
 * @method null|string getMethod()
 * @method null|UrlObject getUrl()
 * @method null|AuthObject getAuth()
 * @method null|HeaderObject getHeader()
 * @method null|RequestBodyObject getBody()
 * @method self setDescription(DescriptionObject $description)
 * @method self setUrl(UrlObject $url)
 * @method self setAuth(AuthObject $auth)
 * @method self setHeader(HeaderObject $header)
 * @method self setBody(RequestBodyObject $body)
 */
class RequestObject extends AbstractDataObject
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

    /** @var \PostmanGenerator\Objects\AuthObject */
    protected $auth;

    /** @var \PostmanGenerator\Objects\RequestBodyObject */
    protected $body;

    /** @var \PostmanGenerator\Objects\DescriptionObject */
    protected $description;

    /** @var \PostmanGenerator\Objects\HeaderObject */
    protected $header;

    /** @var string */
    protected $method;

    /** @var \PostmanGenerator\Objects\UrlObject */
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
     * @return \PostmanGenerator\Objects\RequestObject
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
