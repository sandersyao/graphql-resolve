<?php


namespace GraphQLResolve\Tests;


use GraphQL\Language\DirectiveLocation;
use GraphQLResolve\AbstractDirective;

class UpperCase extends AbstractDirective
{
    /**
     * UpperCase constructor.
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $config = array_merge($config, [
            'name'          => 'uppercase',
            'description'   => '测试指令',
            'locations'     => [
                DirectiveLocation::FIELD,
            ],
        ]);
        parent::__construct($config);
    }

    /**
     * 执行
     *
     * @param $parent
     * @param string $field
     * @param mixed $value
     * @param array $args
     * @return mixed|string
     */
    public function invoke($parent, string $field, $value, array $args)
    {
        return  strtoupper($value);
    }
}
