<?php
declare(strict_types=1);

namespace PostmanGenerator\Objects;

use PostmanGenerator\Exceptions\InvalidAuthTypeException;

/**
 * @method string getType()
 */
class AuthObject extends AbstractDataObject
{
    /**
     * Configured auth type.
     *
     * @var string[]
     */
    public static $authSet = [
        'awsv4',
        'basic',
        'bearer',
        'ntlm',
        'noauth',
        'oauth1',
        'oauth2'
    ];

    /**
     * @var string
     */
    protected $type = 'noauth';

    /**
     * Get auth configuration.
     *
     * @return mixed[]
     */
    public function getConfig(): array
    {
        return $this->{$this->getType()};
    }

    /**
     * Set auth value for type.
     *
     * @param mixed[] $value
     *
     * @return \PostmanGenerator\Objects\AuthObject
     */
    public function setConfig(array $value): self
    {
        $this->{$this->getType()} = $value;

        return $this;
    }

    /**
     * Set type based on set.
     *
     * @param string $type
     *
     * @return \PostmanGenerator\Objects\AuthObject
     *
     * @throws \PostmanGenerator\Exceptions\InvalidAuthTypeException
     */
    public function setType(string $type): self
    {
        if (\in_array($type, self::$authSet) === false) {
            throw new InvalidAuthTypeException(\sprintf('Invalid auth type:[%s]', $type));
        }

        $this->type = $type;

        return $this;
    }

    /**
     * Serialize object as array.
     *
     * @return mixed[]
     */
    public function toArray(): array
    {
        $type = $this->getType();

        return ['type' => $this->getType()] + [$type => $this->{$type}];
    }
}
