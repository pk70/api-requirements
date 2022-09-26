<?php

namespace App\Http\Controllers\Api\Products;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Interfaces\ProductsRepositoryInterface;
use App\Http\Controllers\Api\ApistatusController;

class ProductsController extends ApistatusController
{

    public function __construct(private ProductsRepositoryInterface $productRepository)
    {
    }

    public function show(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category' => 'nullable|string',
            'price_min' => 'nullable|numeric|required_with:price_max',
            'price_max' => 'nullable|numeric|required_with:price_min',
        ]);
        if ($validator->fails()) {
            return $this->sendError('error', $validator->errors());
        }
        return $this->sendResponse($this->productRepository->products($request), 'successfully done');
    }
}
