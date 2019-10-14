<?php


namespace GraphQLResolve;


use Overblog\DataLoader\DataLoader;
use UnexpectedValueException;

/**
 * Class LoaderRegistry
 *
 * @package GraphQLResolve
 */
class LoaderRegistry extends AbstractRegistry
{
    /**
     * 获取键
     *
     * @param mixed $object
     * @return string
     */
    public function getKey($object): string
    {
        if (!($object instanceof DataLoader)) {

            $class  = is_object($object)    ? get_class($object)    : 'Scalar';
            throw new UnexpectedValueException(
                'Unexpect loader class ' . $class .
                ', loader should be instance of ' . DataLoader::class . ' or its subclass.'
            );
        }

        return  get_class($object);
    }
}
