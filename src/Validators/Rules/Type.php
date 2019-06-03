<?php
namespace GraphQLResolve\Validators\Rules;

use GraphQLResolve\Traits\Singleton;
use GraphQLResolve\Validators\NotExists;
use \UnexpectedValueException;

/**
 * 类型校验
 */
class Type
    implements Contract
{
    use Singleton;

    protected $mapTypeCallback;

    public function __construct()
    {
        $this->mapTypeCallback  = [
            'int'       => 'is_int',
            'float'     => 'is_float',
            'number'    => 'is_numeric',
            'string'    => 'is_string',
            'bool'      => 'is_bool',
            'array'     => 'is_array',
            'callable'  => 'is_callable',
            'resource'  => 'is_resource',
        ];
    }

    public function handler($value, array $args = [])
    {
        if ($value instanceof NotExists) {

            return  ;
        }

        foreach ($args as $type) {

            if (!isset($this->mapTypeCallback[$type])) {

                throw new UnexpectedValueException('Cannot assert type ' . $type);
            }

            if (call_user_func($this->mapTypeCallback[$type], $value)) {

                return ;
            }
        }

        $class  = is_scalar($value) ? 'scalar'  : (is_resource($value)  ? 'resource'    : get_class($value));

        throw new UnexpectedValueException('Unexpected value ' . $class . ' for type ' . implode(' or ', $args));
    }
}
