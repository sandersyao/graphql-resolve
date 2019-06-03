<?php
namespace GraphQLResolve\Traits;

use GraphQLResolve\Contracts\HasInterface as HasInterfaceContract;
use \LogicException;

Trait HasInterface
{
    public function getInterfaces(): array
    {
        if (!isset($this->interfaces) && $this instanceof HasInterfaceContract) {

            throw new LogicException('attribute `interfaces` MUST be set on class ' . get_called_class() . '.');
        }

        if (!is_array($this->interfaces) && !is_callable($this->interfaces)) {

            throw new LogicException('attribute `interfaces` MUST be an array or a callable type on ' . get_called_class() . '.');
        }

        return $this->interfaces;
    }
}
