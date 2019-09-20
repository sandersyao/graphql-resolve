<?php


namespace GraphQLResolve;


use GraphQL\Language\AST\DirectiveNode;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Executor\Executor;

abstract class AbstractObjectType extends ObjectType
{
    /**
     * 解析字段方法模板
     */
    const RESOLVE_FIELD_TEMPLATE = 'resolve%sField';

    /**
     * 获取字段
     *
     * @return mixed 字段配置
     */
    abstract public function fields();

    /**
     * AbstractObjectType constructor.
     * @param array $config 配置数据
     */
    public function __construct(array $config = [])
    {
        $config['fields']       = $this->fieldConfig($this->fields());
        $callbackDescription    = [$this, 'description'];

        if (is_callable($callbackDescription)) {

            $config['descriptions'] = $callbackDescription();
        }

        parent::__construct($config);
    }

    /**
     * 获取返回字段配置
     *
     * @param callable|array $fields 字段配置数据
     * @return array 字段配置
     */
    protected function fieldConfig($fields): array
    {
        $fields = is_callable($fields)  ? $fields() : $fields;
        $config = [];

        foreach ($fields as $key => $fieldInfo) {

            $config[$key]   = $this->getFieldResolver($fieldInfo, $key);
        }

        return  $config;
    }

    /**
     * 加载字段解析逻辑
     *
     * @param array $fieldConfig 字段配置数据
     * @param string $key 字段配置键
     * @return array 字段配置数据
     */
    protected function getFieldResolver(array $fieldConfig, string $key): array
    {
        $fieldName      = $this->getFieldName($fieldConfig, $key);
        $fieldConfig['resolve']   = function (
            $parent,
            $args,
            $context,
            ResolveInfo $resolveInfo
        ) use ($fieldConfig, $fieldName) {

            $fieldValue = $this->resolveExecute($parent, $args, $context, $resolveInfo, $fieldConfig, $fieldName);

            return  $this->directivesExecute($parent, $fieldName, $fieldValue, $resolveInfo);
        };

        return  $fieldConfig;
    }

    /**
     * 获取字段名
     *
     * @param array $fieldConfig 字段配置数据
     * @param string $key 字段配置键
     * @return string 字段名
     */
    private function getFieldName(array $fieldConfig, string $key): string
    {
        $fieldName  = $fieldConfig['name'] ?? $key;

        if (!is_string($fieldName)) {

            throw new \UnexpectedValueException('Field name unexpected.');
        }

        return  $fieldName;
    }

    /**
     * 执行解析逻辑
     *
     * @param mixed $parent 上级节点数据
     * @param array $args 字段参数
     * @param mixed $context 上下文数据
     * @param ResolveInfo $resolveInfo 解析信息
     * @param array $fieldConfig 字段配置数据
     * @param string $fieldName 字段名
     * @return mixed|null 执行结果
     */
    private function resolveExecute(
        $parent,
        array $args,
        $context,
        ResolveInfo $resolveInfo,
        array $fieldConfig,
        string $fieldName
    )
    {
        $originResolve  = isset($fieldConfig['resolve']) && is_callable($fieldConfig['resolve'])
                        ? $fieldConfig['resolve']
                        : null;

        if (is_callable($originResolve)) {

            return  $originResolve($parent, $args, $context, $resolveInfo);
        }

        $callbackField  = [$this, sprintf(self::RESOLVE_FIELD_TEMPLATE, $fieldName)];

        if (is_callable($callbackField)) {

            return  $callbackField($parent, $args, $context, $resolveInfo);
        }

        return  Executor::defaultFieldResolver($parent, $args, $context, $resolveInfo);
    }

    /**
     * 执行指令
     *
     * @param mixed $parent 上级节点数据
     * @param string $fieldName 字段名
     * @param mixed $value 当前值
     * @param ResolveInfo $resolveInfo 解析信息
     * @return mixed 执行结果
     */
    protected function directivesExecute($parent, string $fieldName, $value, ResolveInfo $resolveInfo)
    {
        if (isset($resolveInfo->fieldNodes[0]) && !empty($resolveInfo->fieldNodes[0]->directives)) {

            foreach ($resolveInfo->fieldNodes[0]->directives as $directive) {

                $value  = $this->directiveExecute($parent, $fieldName, $value, $directive);
            }
        }

        return  $value;
    }

    /**
     * 执行字段指令
     *
     * @param mixed $parent 上级节点数据
     * @param string $fieldName 字段名
     * @param mixed $value 当前值
     * @param DirectiveNode $directiveNode 指令解析信息
     * @return mixed 执行结果
     */
    protected function directiveExecute($parent, string $fieldName, $value, DirectiveNode $directiveNode)
    {
        $directive      = DirectiveRegistry::get($directiveNode->name->value);
        $directiveArgs  = [];

        foreach ($directiveNode->arguments as $argument) {

            $directiveArgs[$argument->name->value]  = $argument->value;
        }

        return  $directive->invoke($parent, $fieldName, $value, $directiveArgs);
    }

}
