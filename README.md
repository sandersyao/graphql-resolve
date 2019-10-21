# graphql-resolve
GraphQL逻辑拆分

## 状态

不稳定

最近于2019年9月份重写，简化掉构造逻辑和验证逻辑，并按照 graphql-php 作者建议的进行类型注册。

## 动机

1. 研究 GraphQL 与 PHP 项目相结合的方法
1. 将用户自定义的类型拆分到不同的类型里
1. 将带有解析逻的的字段单独封装
1. 实现指令处理逻辑的抽象化封装

## 使用方法

参照测试用例类型：tests/SchemaTest.php 中的实现

Laravel 框架结合使用的测试用例： tests/Laravel/RequestTest.php

## 需要要解决的问题

1. 对字段的错误输出进行控制
1. Laravel 构建 Schema 用的命令

本项目基于 webonyx/graphql-php 开发
