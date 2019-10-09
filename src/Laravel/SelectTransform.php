<?php


namespace GraphQLResolve\Laravel;


use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Database\Eloquent\Builder;

/**
 * Trait SelectTransform
 * @package GraphQLResolve\Laravel
 */
trait SelectTransform
{
    /**
     * 从解析数据中提取选取字段
     *
     * @param Builder $query 查询构建器
     * @param array $transformRules 提取规则 ['查询字段' => '数据库字段 or 闭包实例']
     * @param ResolveInfo $resolveInfo 解析信息
     * @return Builder 查询构建器
     */
    public function scopeSelectTransform(Builder $query, array $transformRules, ResolveInfo $resolveInfo): Builder
    {
        $fields     = array_keys($resolveInfo->getFieldSelection());
        $selections = collect($transformRules)->filter(function ($value, $key) use ($fields) {
            return  in_array($key, $fields);
        })->transform(function ($value) {
            return value($value);
        })->toArray();

        return  $query->addSelect($selections);
    }
}
