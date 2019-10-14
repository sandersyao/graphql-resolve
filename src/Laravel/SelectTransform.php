<?php


namespace GraphQLResolve\Laravel;


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
     * @param array $fields 字段
     * @return Builder 查询构建器
     */
    public function scopeSelectTransform(Builder $query, array $transformRules, array $fields): Builder
    {
        $selections = collect($transformRules)->filter(function ($value, $key) use ($fields) {
            return  in_array($key, $fields);
        })->transform(function ($value) {
            return value($value);
        })->toArray();

        return  $query->addSelect($selections);
    }
}
