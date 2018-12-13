<?php
declare(strict_types=1);

namespace App;

use App\Interfaces\CollectionInterface;
use App\Interfaces\CollectionRequestInterface;
use App\Interfaces\RequestExampleInterface;
use App\Interfaces\RequestParserInterface;
use App\Objects\CollectionItemObject;
use App\Objects\CollectionSubItemObject;
use App\Objects\DescriptionObject;
use App\Objects\ItemObject;
use App\Objects\RequestObject;

class Collection implements CollectionInterface
{
    /**
     * @var \App\Objects\CollectionItemObject
     */
    private $collectionItem;

    /**
     * Collection constructor.
     *
     * @param \App\Objects\CollectionItemObject $collectionItem
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
     * @return \App\Interfaces\CollectionRequestInterface
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
     * @param \App\Objects\DescriptionObject $description
     *
     * @return \App\Interfaces\CollectionInterface
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
     * @param \App\Interfaces\RequestParserInterface $request
     *
     * @return \App\Interfaces\RequestExampleInterface
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
