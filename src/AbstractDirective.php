<?php


namespace GraphQLResolve;


use GraphQL\Type\Definition\Directive;

abstract class AbstractDirective extends Directive
{
    /**
     * @param $parent
     * @param string $field
     * @param mixed $value
     * @param array $args
     * @return mixed
     */
    abstract public function invoke($parent, string $field, $value, array $args);
}
