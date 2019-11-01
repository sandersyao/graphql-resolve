<?php


namespace GraphQLResolve\Tests\Laravel\Queries;


use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use GraphQLResolve\AbstractResolveField;
use GraphQLResolve\Tests\Laravel\Models\Spu;

class SpuSnQuery extends AbstractResolveField
{
    public function __construct(array $config = [])
    {
        $config = [
            'name'  => 'spuSn',
            'type'  => Type::string(),
            'args'  => [
                'id'    => [
                    'type'  => Type::id(),
                ]
            ],
        ];
        parent::__construct($config);
    }

    public function invoke($parent, array $args, $context, ResolveInfo $resolveInfo)
    {
        return  resolve(Spu::class)->find($args['id'])->sn;
    }
}
