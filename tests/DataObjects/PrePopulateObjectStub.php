<?php
declare(strict_types=1);

namespace Tests\App\DataObjects;

use App\Interfaces\PrePopulateInterface;
use App\Objects\AbstractDataObject;

/**
 * @method null|string getObjectId()
 */
class PrePopulateObjectStub extends AbstractDataObject implements PrePopulateInterface
{
    public const ID_PREFIX = 'obj_';

    /** @var string */
    protected $objectId;

    /**
     * Fill properties before mass assignment.
     *
     * @return void
     */
    public function beforeFill(): void
    {
        $this->objectId = \uniqid(self::ID_PREFIX, true);
    }

    /**
     * Serialize object as array.
     *
     * @return mixed[]
     */
    public function toArray(): array
    {
        return ['id' => $this->getObjectId()];
    }
}
