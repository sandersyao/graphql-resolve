<?php


namespace GraphQLResolve\Tests;


use GraphQL\Type\Definition\UnionType;
use GraphQLResolve\TypeRegistry;

class SearchResult extends UnionType
{
    public function __construct($config = [])
    {
        $config['name']     = 'SearchResult';
        $config['types']    = [
            TypeRegistry::get('Order'),
            TypeRegistry::get('Sku'),
        ];
        $config['resolveType']  = function ($value) {

            list($type)   = explode(':', $value['id'], 2);

            switch ($type) {
                case 'sku'  :
                    return  TypeRegistry::get('Sku');
                case 'order'    :
                    return  TypeRegistry::get('Order');
            }
        };
        parent::__construct($config);
    }
}
