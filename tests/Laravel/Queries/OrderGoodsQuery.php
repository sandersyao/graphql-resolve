<?php


namespace GraphQLResolve\Tests\Laravel\Queries;


use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use GraphQLResolve\AbstractResolveField;
use GraphQLResolve\LoaderRegistry;
use GraphQLResolve\Tests\Laravel\DataLoader\Sku;
use GraphQLResolve\Tests\Laravel\Models\OrderGoods;
use GraphQLResolve\Tests\Laravel\Resources\OrderGoods as OrderGoodsResource;
use GraphQLResolve\TypeRegistry;
use Overblog\DataLoader\DataLoader;

class OrderGoodsQuery extends AbstractResolveField
{
    public function __construct(array $config = [])
    {
        $config = array_merge([
            'name'          => 'orderGoods',
            'type'          => Type::listOf(TypeRegistry::get('OrderGoods')),
            'description'   => '订单商品列表',
        ], $config);
        parent::__construct($config);
    }

    public function invoke($parent, array $args, $context, ResolveInfo $resolveInfo)
    {
        $id         = isset($args['order_id'])  ? $args['order_id'] : $parent['id'];
        $fields     = array_keys($resolveInfo->getFieldSelection());
        $orderGoods = OrderGoods::query()
            ->selectTransform([
                'sku'               => 'sku_id',
                'quantity'          => 'quantity',
                'tagPrice'          => 'tag_price',
                'tagAmount'         => 'tag_amount',
                'shouldPayAmount'   => 'should_pay_amount',
                'realPayAmount'     => 'real_pay_amount',
            ], $fields)
            ->where('order_id', $id)
            ->get();

        if (in_array('sku', $fields)) {

            $fieldsLv2  = $resolveInfo->getFieldSelection(1);
            $fieldsSku  = array_keys($fieldsLv2['sku']);
            $mapSku     = DataLoader::await(LoaderRegistry::get(Sku::class)->loadMany($orderGoods->map(function ($orderGoods) use ($fieldsSku) {
                return  [$orderGoods->sku_id, $fieldsSku];
            })->toArray()));
            $orderGoods->transform(function ($orderGoods, $key) use ($mapSku) {

                $orderGoods->sku    = $mapSku[$key];

                return  $orderGoods;
            });
        }

        return  $orderGoods->map(function ($orderGoods) {

            return  (new OrderGoodsResource($orderGoods))->toArray(request());
        });
    }
}
