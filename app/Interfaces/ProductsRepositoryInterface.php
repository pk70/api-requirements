<?php
namespace App\Interfaces;


interface ProductsRepositoryInterface{

    public function products(array $request_array);
    public function category($array,string $category_name,float $filter_price);
    public function default(array $array,float $filter_price);
   // public function jsonarray_decode(array $json_array);

}

?>
