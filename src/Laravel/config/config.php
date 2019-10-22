<?php
return [

    /**
     * 加载类型列表
     *
     * [
     *   CustomQuery::class,
     *   CustomMutation::class,
     *   CustomSubscription::class,
     * ]
     */
    'types'         => [],

    /**
     * 自定义指令列表
     *
     * [
     *   CustomDirective::class,
     * ]
     */
    'directives'    => [],

    /**
     * 数据加载器列表
     *
     * [
     *   CustomLoader::class,
     * ]
     */
    'loaders'       => [],

    /**
     * 上下文数据
     *
     * 应只赋值一次执行过程中不要改变
     */
    'contextClass'  => GraphQLResolve\Laravel\ContextDefault::class
];
