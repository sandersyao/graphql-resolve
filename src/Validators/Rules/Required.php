<?php
namespace GraphQLResolve\Validators\Rules;

use GraphQLResolve\Traits\Singleton;
use GraphQLResolve\Validators\NotExists;
use \UnexpectedValueException;

/**
 * 必填校验规则
 */
class Required
    implements Contract
{
    use Singleton;

    public function handler($value, array $args = [])
    {
        if ($value instanceof NotExists) {

            throw new UnexpectedValueException('invalid value for required');
        }
    }
}
