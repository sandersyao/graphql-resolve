<?php


namespace GraphQLResolve\Tests\Sim;


use GraphQLResolve\AbstractEnumType;

class OrderStatus extends AbstractEnumType
{
    public function values(): array
    {
        return [
            'NEW' => [
                'value' => '1',
            ],
            'CHECKED' => [
                'value' => '2',
            ],
            'CANCELED' => [
                'value' => '3',
            ],
        ];
    }
}