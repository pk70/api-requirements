<?php

namespace App\Repository;
use Illuminate\Support\Arr;

use function PHPSTORM_META\map;
use App\Interfaces\ProductsRepositoryInterface;

class ProductsRepository implements ProductsRepositoryInterface
{
   public function products(array $request_param)
   {

    $collection = jsonarray_decode_from_file(storage_path() . "/data.json");
    $data=$this->default($collection,$request_param['price_min']);
    if(isset($request_param['category']) && isset($request_param['price_min'])){
        $data=$this->category($collection,'insurance',$request_param['price_min']);
    }

    return $data;

   }

   public function category($array,string $category_name,$price_filter)
   {
    $arr=[];
    foreach ($array as $key => $value) {
       if($value['category']==$category_name){
        $arr[]=$value;
       }
    }
    $collection=collect($arr);
    $response=$collection->map(function($items) use ($value){
        if($items['category']=='insurance'){
            return [
                'sku'=>$items['sku'],
                'name'=>$items['name'],
                'category'=>$items['category'],
                'price'=>array(
                    'original'=>$items['price'],
                    'final'=>($items['price']-$items['price']*30/100),
                    //'discount_percentage'=>'30'.htmlspecialchars("%", ENT_QUOTES),
                    'discount_percentage'=>"30%",
                    'currency'=>'EUR'
                )
            ];
        }else{
            return [
                'sku'=>$items['sku'],
                'name'=>$items['name'],
                'category'=>$items['category'],
                'price'=>array(
                    'original'=>$items['price'],
                    'final'=>$items['price'],
                    //'discount_percentage'=>'30'.htmlspecialchars("%", ENT_QUOTES),
                    'discount_percentage'=>null,
                    'currency'=>'EUR'
                )
            ];
        }


    });

    return $response;
   }
   public function default($array,$price_filter)
   {

    $collection=collect($array);
    $response=$collection->map(function($items){
        if($items['category']=='insurance'){
            return [
                'sku'=>$items['sku'],
                'name'=>$items['name'],
                'category'=>$items['category'],
                'price'=>array(
                    'original'=>$items['price'],
                    'final'=>($items['price']-$items['price']*30/100),
                    //'discount_percentage'=>'30'.htmlspecialchars("%", ENT_QUOTES),
                    'discount_percentage'=>"30%",
                    'currency'=>'EUR'
                )
            ];
        }elseif($items['sku']==000003){
            return [
                'sku'=>$items['sku'],
                'name'=>$items['name'],
                'category'=>$items['category'],
                'price'=>array(
                    'original'=>$items['price'],
                    'final'=>($items['price']-$items['price']*15/100),
                    //'discount_percentage'=>'30'.htmlspecialchars("%", ENT_QUOTES),
                    'discount_percentage'=>"15%",
                    'currency'=>'EUR'
                )
            ];

        }else{
            return [
                'sku'=>$items['sku'],
                'name'=>$items['name'],
                'category'=>$items['category'],
                'price'=>array(
                    'original'=>$items['price'],
                    'final'=>$items['price'],
                    //'discount_percentage'=>'30'.htmlspecialchars("%", ENT_QUOTES),
                    'discount_percentage'=>null,
                    'currency'=>'EUR'
                )
            ];
        }


    });

    return $response;
   }
}
