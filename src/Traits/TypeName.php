<?php

namespace GraphQLResolve\Traits;

use Closure;

/**
 * 类型名称
 *
 * Trait TypeName
 * @package GraphQLResolve\Traits
 */
trait TypeName
{
    /**
     * 获取名称
     *
     * @return string
     */
    public function name(): string
    {
        return $this->getDefaultAttribute('name', function () {

            $className  = get_called_class();
            $classSplit = explode('\\', $className);

            return      ucfirst(array_pop($classSplit));
        });
    }

    /**
     * 获取默认属性
     *
     * @param string $attributeName
     * @param Closure $default
     * @return mixed
     */
    abstract protected function getDefaultAttribute(string $attributeName, Closure $default);
}
