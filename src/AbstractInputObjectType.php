<?php
namespace GraphQLResolve;

use GraphQLResolve\Traits\Singleton;
use GraphQLResolve\Traits\TypeDescription;
use GraphQLResolve\Traits\HasDefaultAttribute;
use GraphQLResolve\Builders\InputObjectTypeBuilder;
use GraphQL\Type\Definition\InputObjectType;

/**
 * 抽象输入对象类型
 *
 * Class AbstractInputObjectType
 * @package GraphQLResolve
 */
abstract class AbstractInputObjectType
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
     * 静态获取InputObjectType对象
     *
     * @return InputObjectType
     */
    public static function getObject(): InputObjectType
    {
        return static::getInstance()->fetch();
    }

    /**
     * 获取InputObjectType对象
     *
     * @return InputObjectType
     */
    public function fetch(): InputObjectType
    {
        if (empty($this->object)) {

            $this->object   = $this->build();
        }

        return  $this->object;
    }

    /**
     * 生成InputObjectType对象
     *
     * @return InputObjectType
     */
    protected function build(): InputObjectType
    {
        $builder    = InputObjectTypeBuilder::getInstance()
            ->name($this->name())
            ->description($this->description())
            ->fields($this->fields());

        return  $builder->build();
    }
}
