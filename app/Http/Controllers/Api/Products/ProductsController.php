<?php

namespace App\Http\Controllers\Api\Products;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApistatusController;
use App\Interfaces\ProductsRepositoryInterface;

class ProductsController extends ApistatusController
{

    public function __construct(private ProductsRepositoryInterface $productRepository)
    {
    }

    public function show(Request $request)
    {
       return $this->productRepository->products($request->all());
        //return $request->all();
    }
}
