# graphql-resolve
GraphQL逻辑拆分

## 状态

不稳定

## 动机

1. 将用户自定义的类型拆分到不同的类型里
1. 将带有解析逻的的字段单独封装

## Hello World

### 第1步：定义根查询

定义根查询 Query

```php
use GraphQLResolve\AbstractObjectType;

class Query extends AbstractObjectType
{
    public function fields()
    {
        return function () {

            return [];
        };
    }
}
```

定义根变更 Mutation

```php
use GraphQLResolve\AbstractObjectType;

class Mutation extends AbstractObjectType
{
    public function fields()
    {
        return function () {

            return [];
        };
    }
}
```

实例化 Schema 类型

```php
use GraphQL\Type\Schema;

$schema = new Schema([
    'query'     => Query::getObject(),
    'mutation'  => Mutation::getObject(),
]);
```

我们现在有了一个Schema，包含两个根查询一个 mutation 和一个 query，非常不错！
:trollface: 然并卵~ 它既无法响应任何请求也没有定义任何类型描述。

### 第2步：加入请求

声明一个请求，请求是什么？我们上面已经有请求了？我们管Mutation也继承 (extends) 了请求？为什么？

我理解的 GraphQL 并没有真正意义上的请求，它只提供了数据之间的关系，并通过字段说明要服务端要提供的内容以及通过参数说明如何提供，至于结果则根据类型进行约束。

所以，所有的字段 (Field) 均可以成为实际意义上需要解析 (resolve) 的请求 (Query) ，也可以是简单的由父母节点提供的值。

那么我们来完成一个简单的 Hello 请求如下：

```php
use Closure;
use GraphQL\Type\Definition\Type;
use GraphQLResolve\AbstractQuery;

class Hello extends AbstractQuery
{
    /**
     * 返回的类型
     *
     * @return \GraphQL\Type\Definition\NonNull
     */
    public function type()
    {
        return  Type::nonNull(Type::string());
    }

    /**
     * 解析方法
     *
     * @return Closure
     */
    public function resolve(): Closure
    {
        return  function () {

            return  'Hello world';
        };
    }
}
```

基于第1步中的空查询，将以上查询通过fetchOptions方法获取其配置，加入到查询中。

```php
use GraphQLResolve\AbstractObjectType;

class Query extends AbstractObjectType
{
    public function fields()
    {
        return function () {

            return [
                Hello::fetchOptions(),
            ];
        };
    }
}
```

虽然仍然看不到任何结果，但可以解释一下目前我们做的事情，我们通过 Hello 类型，声明了一个字段，我们将该字段的返回类型锁定为非空的字符串值；另外，我们定义了该字段的解析方法，并在方法中返回了字符串'Hello world'。

让我们继续，直到程序可以响应某个查询，我们需要调用 graphql-php 项目的门面方法：

```php
use GraphQL\GraphQL;
use GraphQL\Type\Schema;

$schema         = new Schema([
    'query'     => Query::getObject(),
    'mutation'  => Mutation::getObject(),
]);
$query          = '{hello}';
$rootValue      = null;
$variableValues = [];
$context        = [];
$operationName  = null;

$result         = GraphQL::executeQuery(
    $schema,
    $query,
    $rootValue,
    $context,
    $variableValues,
    $operationName
);
$data           = $result->toArray();
var_dump($data);
```

上面我们使用了一个简单的查询 "{hello}" 程序将输出：

```php
array(1) {
  ["data"]=>
  array(1) {
    ["hello"]=>
    string(11) "Hello world"
  }
}
```

基于 webonyx/graphql-php 开发
