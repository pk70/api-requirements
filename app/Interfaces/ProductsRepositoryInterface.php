<?php
namespace App\Interfaces;

use Illuminate\Http\Request;

interface ProductsRepositoryInterface{

    public function products(Request $request_filter);
    public function filterData(array $array,Request $request_filter);
    public function withoutFilterData(array $array);
    public function categoryFilterData(array $data,string $category_name);
    public function priceFilterData(array $data,string $price_min,$price_max);
    public function categoryAndPriceFilterData(array $data,string $category_name,$price_min,$price_max);

}
