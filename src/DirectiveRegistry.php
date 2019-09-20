<?php


namespace GraphQLResolve;


class DirectiveRegistry extends AbstractRegistry
{
    /**
     * 获取Key
     *
     * @param $directive
     * @return string
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
     * @return array
     */
    static public function getAll()
    {
        return  array_values(self::getInstance()->map);
    }
}
