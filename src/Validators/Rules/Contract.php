<?php


namespace GraphQLResolve\Validators\Rules;

use \UnexpectedValueException;

interface Contract
{
    /**
     * @param mixed $value
     * @param array $args
     * @return mixed
     * @throws UnexpectedValueException
     */
    public function handler($value, array $args = []);
}