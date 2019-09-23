<?php


namespace GraphQLResolve;


use GraphQL\Executor\Executor;
use GraphQL\Language\AST\DirectiveNode;
use GraphQL\Type\Definition\FieldDefinition;
use GraphQL\Type\Definition\ResolveInfo;

class SimpleField extends FieldDefinition
{
    public function __construct(array $config)
    {
        $config = array_merge($config, [
            'resolve'   => [$this, 'resolve'],
        ]);
        parent::__construct($config);
    }

    /**
     * @param mixed $parent 上级节点数据
     * @param array $args 参数
     * @param mixed $context 上下文数据
     * @param ResolveInfo $resolveInfo 解析信息
     * @return mixed 执行结果
     */
    public function resolve($parent, array $args, $context, ResolveInfo $resolveInfo)
    {
        $fieldValue = Executor::defaultFieldResolver($parent, $args, $context, $resolveInfo);

        return  $this->directivesExecute($parent, $fieldValue, $resolveInfo);
    }

    /**
     * 执行指令
     *
     * @param mixed $parent 上级节点数据
     * @param mixed $value 当前值
     * @param ResolveInfo $resolveInfo 解析信息
     * @return mixed 执行结果
     */
    protected function directivesExecute($parent, $value, ResolveInfo $resolveInfo)
    {
        if (isset($resolveInfo->fieldNodes[0]) && !empty($resolveInfo->fieldNodes[0]->directives)) {

            foreach ($resolveInfo->fieldNodes[0]->directives as $directive) {

                $value  = $this->directiveExecute($parent, $value, $directive);
            }
        }

        return  $value;
    }

    /**
     * 执行字段指令
     *
     * @param mixed $parent 上级节点数据
     * @param mixed $value 当前值
     * @param DirectiveNode $directiveNode 指令解析信息
     * @return mixed 执行结果
     */
    protected function directiveExecute($parent, $value, DirectiveNode $directiveNode)
    {
        $directive      = DirectiveRegistry::get($directiveNode->name->value);
        $directiveArgs  = [];

        foreach ($directiveNode->arguments as $argument) {

            $directiveArgs[$argument->name->value]  = $argument->value;
        }

        return  $directive->invoke($parent, $this->name, $value, $directiveArgs);
    }
}
