<?php


namespace GraphQLResolve\Tests\Sim;

use GraphQLResolve\AbstractEnumType;

/**
 * 商品单位
 *
 * Class GoodsUnit
 * @package GraphQLResolve\Tests\Sim
 */
class GoodsUnit extends AbstractEnumType
{
    public function values(): array
    {
        return [
            [
                'name' => 'KG',
                'value' => 'kg',
            ],
            [
                'name' => 'UNIT',
                'value' => 'unit',
            ],
            [
                'name' => 'g',
                'value' => 'g',
            ],
            [
                'name' => 'Bottle',
                'value' => 'bottle',
            ],
            [
                'name' => 'Liter',
                'value' => 'L',
            ],
        ];
    }
}