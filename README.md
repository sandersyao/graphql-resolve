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


本项目基于 webonyx/graphql-php 开发
