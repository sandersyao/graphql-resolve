<?php


namespace GraphQLResolve\Tests;


use GraphQLResolve\AbstractObjectType;

class DataLoaderQuery extends AbstractObjectType
{
    const DATA_USER     = [
        '1' => [
            'id'    => 1,
            'name'  => 'a',
        ],
        '2' => [
            'id'    => 2,
            'name'  => 'b',
        ],
        '3' => [
            'id'    => 3,
            'name'  => 'c',
        ],
        '4' => [
            'id'    => 4,
            'name'  => 'd',
        ],
        '5' => [
            'id'    => 5,
            'name'  => 'e',
        ],
    ];
    const DATA_FRIENDS  = [
        '1' => ['2', '3', '4'],
        '2' => ['1', '3', '4'],
        '3' => ['1', '2', '4'],
        '4' => ['1', '2', '3'],
    ];

    public function fields()
    {
        return  [
            new Me(),
        ];
    }

    public function __construct(array $config = [])
    {
        $config = array_merge($config, [
            'name'          => 'Query',
            'description'   => 'DataLoader测试查询',
        ]);
        parent::__construct($config);
    }
}
