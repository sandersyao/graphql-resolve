<?php
/**
 * 路由定义
 */
Route::post('/graphql', 'GraphQLResolve\\Laravel\\GraphQLController@resolve')
    ->name('graphql');
