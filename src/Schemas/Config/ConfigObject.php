<?php
declare(strict_types=1);

namespace PostmanGenerator\Schemas\Config;

use PostmanGenerator\Schemas\AbstractSchema;

/**
 * @method null|string getExportDirectory()
 * @method bool isOverrideExisting()
 * @method self setExportDirectory(string $exportDirectory)
 * @method self setOverrideExisting(bool $overrideExisting)
 */
class ConfigObject extends AbstractSchema
{
    /**
     * @var string
     */
    protected $exportDirectory;

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