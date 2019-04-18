<?php
declare(strict_types=1);

namespace PostmanGenerator;

use PostmanGenerator\Interfaces\CollectionRequestInterface;
use PostmanGenerator\Interfaces\RequestExampleInterface;
use PostmanGenerator\Interfaces\RequestParserInterface;
use PostmanGenerator\Schemas\CollectionSubItemSchema;
use PostmanGenerator\Schemas\ItemSchema;
use PostmanGenerator\Schemas\RequestSchema;

class CollectionRequest implements CollectionRequestInterface
{
    /**
     * @var \PostmanGenerator\Schemas\CollectionSubItemSchema
     */
    private $subItem;

    /**
     * CollectionRequest constructor.
     *
     * @param \PostmanGenerator\Schemas\CollectionSubItemSchema $subItem
     */
    public function __construct(CollectionSubItemSchema $subItem)
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
        $item = new ItemSchema();
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
