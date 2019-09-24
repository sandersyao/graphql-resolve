<?php


namespace GraphQLResolve;


use GraphQL\Language\AST\DirectiveNode;
use GraphQL\Type\Definition\FieldDefinition;
use GraphQL\Type\Definition\ResolveInfo;

/**
 * Class AbstractResolveField
 * @package GraphQLResolve
 */
abstract class AbstractResolveField extends FieldDefinition
{
    /**
     * 执行
     *
     * @param mixed $parent 上级数据
     * @param array $args 参数
     * @param mixed $context 上下文数据
     * @param ResolveInfo $resolveInfo 解析信息
     * @return mixed 执行结果
     */
    abstract public function invoke($parent, array $args, $context, ResolveInfo $resolveInfo);

    /**
     * AbstractResolveField constructor.
     *
     * @param array $config 字段配置数据
     */
    public function __construct(array $config)
    {
        $config  = array_merge(
            $config,
            [
                'name'      => $this->getName($config),
                'resolve'   => [$this, 'resolve'],
            ]
        );
        parent::__construct($config);
    }

    /**
     * 获取字段名
     *
     * @param array $config
     * @return string
     */
    private function getName(array $config): string
    {
        if (isset($config['name']) && is_string($config['name'])) {

            return  $config['name'];
        }

        $path = explode('\\', get_called_class());
        return  lcfirst(preg_replace([
            '~Field$~',
            '~Query$~'
        ],'', end($path)));
    }

    /**
     * 解析
     *
     * @param mixed $parent 上级节点数据
     * @param array $args 参数
     * @param mixed $context 上下文数据
     * @param ResolveInfo $resolveInfo 解析信息
     * @return mixed 执行结果
     */
    public function resolve($parent, array $args, $context, ResolveInfo $resolveInfo)
    {
        $fieldValue = $this->invoke($parent, $args, $context, $resolveInfo);

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
