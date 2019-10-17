<?php


namespace GraphQLResolve\Tests\Laravel\Queries;


use GraphQL\Type\Definition\ResolveInfo;
use GraphQLResolve\AbstractResolveField;
use GraphQLResolve\LoaderRegistry;
use GraphQLResolve\Tests\Laravel\DataLoader\User;
use GraphQLResolve\TypeRegistry;

/**
 * Class UserQuery
 * @package GraphQLResolve\Tests\Laravel\Queries
 */
class UserQuery extends AbstractResolveField
{
    /**
     * UserQuery constructor.
     * @param array $config
     */
    public function __construct($config = [])
    {
        $config = array_merge([
            'name'          => 'user',
            'type'          => TypeRegistry::get('User'),
            'description'   => '用户数据',
        ], $config);
        parent::__construct($config);
    }

    /**
     * 执行解析逻辑
     *
     * @param mixed $parent
     * @param array $args
     * @param mixed $context
     * @param ResolveInfo $resolveInfo
     * @return mixed
     */
    public function invoke($parent, array $args, $context, ResolveInfo $resolveInfo)
    {
        $userId = isset($args['id'])    ? $args['id']   : $parent['user_id'];
        $result = LoaderRegistry::get(User::class)
            ->load([$userId, $resolveInfo->getFieldSelection()]);

        return $result;
    }
}
