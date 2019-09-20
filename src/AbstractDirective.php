<?php


namespace GraphQLResolve;


use GraphQL\Type\Definition\Directive;

/**
 * Class AbstractDirective
 * @package GraphQLResolve
 */
abstract class AbstractDirective extends Directive
{
    /**
     * @param mixed $parent 上级节点数据
     * @param string $field 字段名
     * @param mixed $value 当前值
     * @param array $args 参数列表
     * @return mixed 执行结果
     * @api
     */
    abstract public function invoke($parent, string $field, $value, array $args);
}
