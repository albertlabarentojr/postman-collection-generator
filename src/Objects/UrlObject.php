<?php
declare(strict_types=1);

namespace App\Objects;

/**
 * @method null|string getRaw()
 * @method null|string getProtocol()
 * @method string[] getHost()
 * @method string[] getPath()
 * @method self setRaw(string $raw)
 * @method self setProtocol(string $protocol)
 * @method self setHost(string[] $hosts)
 * @method self setPath(string[] $paths)
 */
class UrlObject extends AbstractDataObject
{
    /** @var string */
    protected $raw;

    /** @var string */
    protected $protocol;

    /** @var string[] */
    protected $host;

    /** @var string[] */
    protected $path;

    /**
     * Serialize object as array.
     *
     * @return mixed[]
     */
    public function toArray(): array
    {
        return [
            'raw' => $this->getRaw(),
            'protocol' => $this->getProtocol(),
            'host' => $this->getHost(),
            'path' => $this->getPath()
        ];
    }
}
