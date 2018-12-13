<?php
declare(strict_types=1);

namespace App;

use App\Interfaces\CollectionRequestInterface;
use App\Interfaces\RequestExampleInterface;
use App\Interfaces\RequestParserInterface;
use App\Objects\CollectionSubItemObject;
use App\Objects\ItemObject;
use App\Objects\RequestObject;

class CollectionRequest implements CollectionRequestInterface
{
    /**
     * @var \App\Objects\CollectionSubItemObject
     */
    private $subItem;

    /**
     * CollectionRequest constructor.
     *
     * @param \App\Objects\CollectionSubItemObject $subItem
     */
    public function __construct(CollectionSubItemObject $subItem)
    {
        $this->subItem = $subItem;
    }

    /**
     * Add request example.
     *
     * @param string $exampleName
     * @param \App\Interfaces\RequestParserInterface $request
     *
     * @return \App\Interfaces\RequestExampleInterface
     */
    public function addRequest(string $exampleName, RequestParserInterface $request): RequestExampleInterface
    {
        $item = new ItemObject();
        $item->setName($exampleName);

        $this->subItem->addItem($item);

        return new RequestExample($item, $request);
    }

    /**
     * Add configuration to collection object
     *
     * @param array $config
     *
     * @return void
     */
    public function addConfig(array $config): void
    {
        $this->subItem->fill($config);
    }
}
