<?php
namespace GraphQLResolve;

use GraphQLResolve\Traits\Singleton;
use GraphQLResolve\Traits\TypeDescription;
use GraphQLResolve\Traits\InterfaceResolveType;
use GraphQLResolve\Traits\HasDefaultAttribute;
use GraphQLResolve\Builders\InterfaceTypeBuilder;
use GraphQL\Type\Definition\InterfaceType;
use \Closure;

/**
 * 抽象接口
 *
 * Class AbstractInterface
 * @package GraphQLResolve
 */
abstract class AbstractInterface
{
    use Singleton, HasDefaultAttribute, TypeDescription, InterfaceResolveType;

    /**
     * InterfaceType对象
     */
    protected $object;

    /**
     * 获取字段列表
     *
     * @return mixed
     */
    abstract public function fields();

    /**
     * 将自己的字段合并如目标字段
     *
     * @param array $listObject
     * @return array
     */
    public static function mergeFields (array $listObject): array
    {
        $fieldsInterface    = static::getInstance()->fields();
        $listInterface      = is_callable($fieldsInterface)
                            ? $fieldsInterface()
                            : $fieldsInterface;

        return array_merge($listObject, array_filter($listInterface, function ($element, $name) use ($listObject) {

            foreach ($listObject as $nameObject => $itemObject) {

                if (
                    (is_string($name) && $name === $nameObject)
                    || $itemObject['name'] === $element['name']
                ) {

                    return  false;
                }
            }

            return  true;
        }, ARRAY_FILTER_USE_BOTH));
    }

    /**
     * 静态获取InterfaceType对象
     *
     * @return  InterfaceType
     */
    public static function getObject(): InterfaceType
    {
        return static::getInstance()->fetch();
    }

    /**
     * 获取InterfaceType对象
     *
     * @return  InterfaceType
     */
    public function fetch(): InterfaceType
    {
        if (empty($this->object)) {

            $this->object   = $this->build();
        }

        return  $this->object;
    }

    /**
     * @return Closure
     */
    public function resolveType(): Closure
    {
        return function () {};
    }

    /**
     * 生成InterfaceType对象
     *
     * @return  InterfaceType
     */
    protected function build(): InterfaceType
    {
        return  InterfaceTypeBuilder::getInstance()
            ->name($this->name())
            ->description($this->description())
            ->fields($this->fields())
            ->resolveType($this->resolveType())
            ->build();
    } 
}
