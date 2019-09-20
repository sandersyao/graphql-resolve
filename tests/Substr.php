<?php


namespace GraphQLResolve\Tests;


use GraphQL\Language\DirectiveLocation;
use GraphQL\Type\Definition\FieldArgument;
use GraphQL\Type\Definition\Type;
use GraphQLResolve\AbstractDirective;

class Substr extends AbstractDirective
{
    /**
     * UpperCase constructor.
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $config = array_merge($config, [
            'name'          => 'substr',
            'description'   => '测试指令带参数',
            'locations'     => [
                DirectiveLocation::FIELD,
            ],
            'args'          => [
                new FieldArgument([
                    'name'          => 'offset',
                    'type'          => Type::nonNull(Type::int()),
                    'description'   => '起始位置',
                    'defaultValue'  => 0,
                ]),
                new FieldArgument([
                    'name'          => 'length',
                    'type'          => Type::int(),
                    'description'   => '截取长度',
                ]),
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
        $offset = (int) $args['offset']->value;

        if (isset($args['length'])) {

            return  substr($value, $offset, (int) $args['length']->value);
        }

        return  substr($value, $offset);
    }
}
