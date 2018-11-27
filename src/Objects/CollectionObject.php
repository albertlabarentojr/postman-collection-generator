<?php
declare(strict_types=1);

namespace App\Objects;

/**
 * @method null|InfoObject getInfo()
 * @method CollectionItemObject[] getItem()
 * @method null|AuthObject getAuth()
 * @method VariableObject[] getVariable()
 * @method self setInfo(InfoObject $info)
 * @method self setItem(CollectionItemObject[] $item);
 * @method self setAuth(AuthObject $auth)
 * @method self setVariable(VariableObject $variable)
 */
class CollectionObject extends AbstractDataObject
{
    /** @var \App\Objects\AuthObject */
    protected $auth;

    /** @var \App\Objects\InfoObject */
    protected $info;

    /** @var \App\Objects\CollectionItemObject[] */
    protected $item = [];

    /** @var \App\Objects\VariableObject[] */
    protected $variable = [];

    /**
     * Add Collection item.
     *
     * @param \App\Objects\CollectionItemObject $item
     *
     * @return \App\Objects\CollectionObject
     */
    public function addItem(CollectionItemObject $item): self
    {
        $this->item[] = $item;

        return $this;
    }

    /**
     * Add variable item.
     *
     * @param \App\Objects\VariableObject $variable
     *
     * @return \App\Objects\CollectionObject
     */
    public function addVariable(VariableObject $variable): self
    {
        $this->variable[] = $variable;

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
            'info' => $this->getInfo(),
            'item' => $this->getItem(),
            'auth' => $this->getAuth(),
            'variable' => $this->getVariable()
        ];
    }
}
