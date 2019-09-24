<?php


namespace GraphQLResolve;

/**
 * Class DirectiveRegistry
 *
 * @package GraphQLResolve
 */
class DirectiveRegistry extends AbstractRegistry
{
    /**
     * 获取指令名称
     *
     * @param mixed $directive 指令对象
     * @return string 指令名称
     */
    protected function getKey($directive): string
    {
        if (!($directive instanceof AbstractDirective)) {

            throw new \UnexpectedValueException(
                'Unexpected argument $directive must a instance of class ' .
                AbstractDirective::class . ' or its subclass.'
            );
        }

        return $directive->name;
    }

    /**
     * 获取全部指令
     *
     * @return array[GraphQLResolve\AbstractDirective] 全部指令列表
     * @api
     */
    static public function getAll()
    {
        return  array_values(self::getInstance()->map);
    }
}
