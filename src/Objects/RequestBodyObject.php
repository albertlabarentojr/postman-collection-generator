<?php
declare(strict_types=1);

namespace App\Objects;

use App\Exceptions\InvalidModeTypeException;

/**
 * @method null|bool isDisabled()
 * @method null|FileObject getFile()
 * @method null|FormParameterObject getFormParameter()
 * @method null|string getMode()
 * @method null|string getRaw()
 * @method null|UrlObject getUrl()
 * @method self setDisabled(bool $disabled)
 * @method self setFile(FileObject $file)
 * @method self setFormParameter(FormParameterObject $formParameter)
 * @method self setRaw(string $raw)
 * @method self setUrl(UrlObject $url)
 */
class RequestBodyObject extends AbstractDataObject
{
    public static $modeSet = ['file', 'formdata', 'raw', 'urlencoded'];

    /** @var bool */
    protected $disabled;

    /** @var \App\Objects\FileObject */
    protected $file;

    /** @var \App\Objects\FormParameterObject */
    protected $formParameter;

    /** @var string */
    protected $mode;

    /** @var string */
    protected $raw;

    /** @var \App\Objects\UrlObject */
    protected $url;

    /**
     * Set request body mode.
     *
     * @param string $mode
     *
     * @return \App\Objects\RequestBodyObject
     *
     * @throws \App\Exceptions\InvalidModeTypeException
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
