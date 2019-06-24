<?php
declare(strict_types=1);

namespace PostmanGenerator\Schemas;

use PostmanGenerator\Exceptions\InvalidModeTypeException;

/**
 * @method null|bool isDisabled()
 * @method null|\PostmanGenerator\Schemas\FileSchema getFile()
 * @method null|\PostmanGenerator\Schemas\FormParameterSchema getFormParameter()
 * @method null|string getMode()
 * @method null|string getRaw()
 * @method null|\PostmanGenerator\Schemas\UrlSchema getUrl()
 * @method self setDisabled(bool $disabled)
 * @method self setFile(\PostmanGenerator\Schemas\FileSchema $file)
 * @method self setFormParameter(\PostmanGenerator\Schemas\FormParameterSchema $formParameter)
 * @method self setRaw(string $raw)
 * @method self setUrl(\PostmanGenerator\Schemas\UrlSchema $url)
 */
class RequestBodySchema extends AbstractSchema
{
    public static $modeSet = ['file', 'formdata', 'raw', 'urlencoded'];

    /** @var bool */
    protected $disabled;

    /** @var \PostmanGenerator\Schemas\FileSchema */
    protected $file;

    /** @var \PostmanGenerator\Schemas\FormParameterSchema */
    protected $formParameter;

    /** @var string */
    protected $mode;

    /** @var string */
    protected $raw;

    /** @var \PostmanGenerator\Schemas\UrlSchema */
    protected $url;

    /**
     * Set request body mode.
     *
     * @param string $mode
     *
     * @return \PostmanGenerator\Schemas\RequestBodySchema
     *
     * @throws \PostmanGenerator\Exceptions\InvalidModeTypeException
     */
    public function setMode(string $mode): self
    {
        if (\in_array($mode, self::$modeSet, true) === false) {
            throw new InvalidModeTypeException(\sprintf('Invalid mode type: [%s]', $mode));
        }

        $this->mode = $mode;

        return $this;
    }

    /**
     * Serialize object as array.
     *
     * @return mixed[]
     */
    public function toArray(): array
    {
        return [
            'disabled' => $this->isDisabled(),
            'file' => $this->getFile(),
            'formdata' => $this->getFormParameter(),
            'mode' => $this->getMode(),
            'raw' => $this->getRaw(),
            'urlencoded' => $this->getUrl()
        ];
    }
}
