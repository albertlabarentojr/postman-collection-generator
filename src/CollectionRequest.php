<?php
declare(strict_types=1);

namespace PostmanGenerator;

use PostmanGenerator\Interfaces\CollectionRequestInterface;
use PostmanGenerator\Interfaces\RequestExampleInterface;
use PostmanGenerator\Interfaces\RequestParserInterface;
use PostmanGenerator\Objects\CollectionSubItemObject;
use PostmanGenerator\Objects\ItemObject;
use PostmanGenerator\Objects\RequestObject;

class CollectionRequest implements CollectionRequestInterface
{
    /**
     * @var \PostmanGenerator\Objects\CollectionSubItemObject
     */
    private $subItem;

    /**
     * CollectionRequest constructor.
     *
     * @param \PostmanGenerator\Objects\CollectionSubItemObject $subItem
     */
    public function __construct(CollectionSubItemObject $subItem)
    {
        $this->subItem = $subItem;
    }

    /**
     * Add request example.
     *
     * @param string $exampleName
     * @param \PostmanGenerator\Interfaces\RequestParserInterface $request
     *
     * @return \PostmanGenerator\Interfaces\RequestExampleInterface
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
