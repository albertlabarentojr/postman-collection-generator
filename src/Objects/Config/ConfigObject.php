<?php
declare(strict_types=1);

namespace PostmanGenerator\Objects\Config;

use PostmanGenerator\Objects\AbstractDataObject;

/**
 * @method null|string getExportDirectory()
 * @method bool isOverrideExisting()
 * @method self setExportDirectory(string $exportDirectory)
 * @method self setOverrideExisting(bool $overrideExisting)
 */
class ConfigObject extends AbstractDataObject
{
    /**
     * @var string
     */
    protected $exportDirectory = __DIR__;

    /**
     * @var bool
     */
    protected $overrideExisting = false;

    /**
     * Serialize object as array.
     *
     * @return mixed[]
     */
    public function toArray(): array
    {
        return [
            'export_directory' => $this->getExportDirectory(),
            'override_existing' => $this->isOverrideExisting()
        ];
    }
}