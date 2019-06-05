<?php
namespace GraphQLResolve;

use GraphQLResolve\Traits\Singleton;
use GraphQLResolve\Traits\TypeDescription;
use GraphQLResolve\Traits\HasDefaultAttribute;
use GraphQLResolve\Builders\ObjectTypeBuilder;
use GraphQL\Type\Definition\ObjectType;

/**
 * 抽象输出对象类型
 *
 * Class AbstractObjectType
 * @package GraphQLResolve
 */
abstract class AbstractObjectType
{
    use Singleton, HasDefaultAttribute, TypeDescription;

    /**
     * ObjectType对象
     */
    protected $object;

    /**
     * 获取字段列表
     *
     * @return mixed
     */
    abstract public function fields();

    /**
     * 静态获取ObjectType对象
     *
     * @return ObjectType
     */
    public static function getObject(): ObjectType
    {
        return static::getInstance()->fetch();
    }

    /**
     * 获取ObjectType对象
     *
     * @return ObjectType
     */
    public function fetch(): ObjectType
    {
        if (empty($this->object)) {

            $this->object   = $this->build();
        }

        return  $this->object;
    }

    /**
     * 生成ObjectType对象
     *
     * @return ObjectType
     */
    protected function build(): ObjectType
    {
        $builder    = ObjectTypeBuilder::getInstance()
            ->name($this->name())
            ->description($this->description())
            ->fields($this->fields());

        if (is_callable([$this, 'implements'])) {

            $builder->interfaces($this->implements());
        }

        return  $builder->build();
    } 
}
