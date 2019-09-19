<?php


namespace GraphQLResolve;


use GraphQL\Type\Definition\ObjectType;

abstract class AbstractObjectType extends ObjectType
{
    /**
     * 获取字段
     *
     * @return mixed
     */
    abstract public function fields();

    /**
     * AbstractObjectType constructor.
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $config['fields']       = [$this, 'fields'];
        $callbackDescription    = [$this, 'description'];

        if (is_callable($callbackDescription)) {

            $config['descriptions'] = $callbackDescription();
        }

        parent::__construct($config);
    }
}
