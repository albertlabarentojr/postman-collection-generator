<?php
declare(strict_types=1);

namespace PostmanGenerator;

use PostmanGenerator\Interfaces\CollectionInterface;
use PostmanGenerator\Interfaces\CollectionRequestInterface;
use PostmanGenerator\Interfaces\RequestExampleInterface;
use PostmanGenerator\Interfaces\RequestParserInterface;
use PostmanGenerator\Objects\CollectionItemObject;
use PostmanGenerator\Objects\CollectionSubItemObject;
use PostmanGenerator\Objects\DescriptionObject;
use PostmanGenerator\Objects\ItemObject;
use PostmanGenerator\Objects\RequestObject;

class Collection implements CollectionInterface
{
    /**
     * @var \PostmanGenerator\Objects\CollectionItemObject
     */
    private $collectionItem;

    /**
     * Collection constructor.
     *
     * @param \PostmanGenerator\Objects\CollectionItemObject $collectionItem
     */
    public function __construct(CollectionItemObject $collectionItem)
    {
        $this->collectionItem = $collectionItem;
    }

    /**
     * Add collection request.
     *
     * @param string $requestName
     *
     * @return \PostmanGenerator\Interfaces\CollectionRequestInterface
     */
    public function addSubCollection(string $requestName): CollectionRequestInterface
    {
        $collectionSubItem = new CollectionSubItemObject();
        $collectionSubItem->setName($requestName);

        $this->collectionItem->addItem($collectionSubItem);

        return new CollectionRequest($collectionSubItem);
    }

    /**
     * Get collection description.
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->collectionItem->getDescription();
    }

    /**
     * Set request description.
     *
     * @param \PostmanGenerator\Objects\DescriptionObject $description
     *
     * @return \PostmanGenerator\Interfaces\CollectionInterface
     */
    public function setDescription(DescriptionObject $description): CollectionInterface
    {
        $this->collectionItem->setDescription($description->getContent());

        return $this;
    }

    /**
     * Add collection request.
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

        $this->collectionItem->addItem($item);

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
        $this->collectionItem->fill($config);
    }
}
