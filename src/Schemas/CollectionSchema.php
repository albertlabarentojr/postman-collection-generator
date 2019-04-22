<?php
declare(strict_types=1);

namespace PostmanGenerator\Schemas;

/**
 * @method null|AuthSchema getAuth()
 * @method null|InfoSchema getInfo()
 * @method VariableSchema[] getVariable()
 * @method self setAuth(AuthSchema $auth)
 * @method self setInfo(InfoSchema $info)
 * @method self setVariable(VariableSchema $variable)
 */
class CollectionSchema extends AbstractItemableSchema
{
    /** @var \PostmanGenerator\Schemas\AuthSchema */
    protected $auth;

    /** @var \PostmanGenerator\Schemas\InfoSchema */
    protected $info;

    /** @var \PostmanGenerator\Schemas\VariableSchema[] */
    protected $variable = [];

    /**
     * Add variable item.
     *
     * @param \PostmanGenerator\Schemas\VariableSchema $variable
     *
     * @return \PostmanGenerator\Schemas\CollectionSchema
     */
    public function addVariable(VariableSchema $variable): self
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
