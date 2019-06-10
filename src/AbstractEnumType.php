<?php


namespace GraphQLResolve;

use GraphQL\Type\Definition\EnumType;
use GraphQLResolve\Builders\EnumTypeBuilder;
use GraphQLResolve\Traits\Singleton;
use GraphQLResolve\Traits\TypeDescription;
use GraphQLResolve\Traits\HasDefaultAttribute;

/**
 * 枚举值
 *
 * Class AbstractEnumType
 * @package GraphQLResolve
 */
abstract class AbstractEnumType
{
    use Singleton, TypeDescription, HasDefaultAttribute;

    /**
     * EnumType对象
     */
    protected $object;

    abstract public function values(): array;

    /**
     * 静态获取ObjectType对象
     *
     * @return EnumType
     */
    public static function getObject(): EnumType
    {
        return static::getInstance()->fetch();
    }

    /**
     * 获取ObjectType对象
     *
     * @return EnumType
     */
    public function fetch(): EnumType
    {
        if (empty($this->object)) {

            $this->object = $this->build();
        }

        return $this->object;
    }

    /**
     * 生成ObjectType对象
     *
     * @return EnumType
     */
    protected function build(): EnumType
    {
        $builder = EnumTypeBuilder::getInstance()
            ->name($this->name())
            ->description($this->description())
            ->values($this->values());

        return $builder->build();
    }

}