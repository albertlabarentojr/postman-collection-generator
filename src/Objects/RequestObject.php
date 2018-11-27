<?php
declare(strict_types=1);

namespace App\Objects;

use App\Exceptions\InvalidRequestMethodException;

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

    /** @var \App\Objects\AuthObject */
    protected $auth;

    /** @var \App\Objects\RequestBodyObject */
    protected $body;

    /** @var \App\Objects\DescriptionObject */
    protected $description;

    /** @var \App\Objects\HeaderObject */
    protected $header;

    /** @var string */
    protected $method;

    /** @var \App\Objects\UrlObject */
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
     * @return \App\Objects\RequestObject
     *
     * @throws \App\Exceptions\InvalidRequestMethodException
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
