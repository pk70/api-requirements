<?php

namespace App\Repository;

use App\Interfaces\ProductsRepositoryInterface;

class ProductsRepository implements ProductsRepositoryInterface
{
    private $response;

    public function products($request_filter)
    {
        $collection = jsonarray_decode_from_file(storage_path() . "/data.json");

        if ($request_filter->hasAny(['category', 'price_min', 'price_max'])) {

            $this->response = $this->filterData($collection, $request_filter);
        } else {
            $this->response = $this->withoutFilterData($collection);
        }

        return $this->response;
    }

    public function filterData($array, $request_filter)
    {
        if ($request_filter->has('category')) {
            $this->response = $this->categoryFilterData($array, $request_filter->input('category'));
        } elseif ($request_filter->has('price_min') && $request_filter->has('price_max')) {
            $this->response = $this->priceFilterData($array, $request_filter->input('price_min'), $request_filter->input('price_max'));
        }
        return $this->response;
    }

    public function withoutFilterData($data)
    {
        $collection = collect($data);
        $this->response = $collection->map(function ($items) {
            if ($items['category'] == 'insurance') {
                return [
                    'sku' => $items['sku'],
                    'name' => $items['name'],
                    'category' => $items['category'],
                    'price' => array(
                        'original' => $items['price'],
                        'final' => ($items['price'] - $items['price'] * 30 / 100),
                        'discount_percentage' => "30%",
                        'currency' => 'EUR'
                    )
                ];
            } elseif ($items['sku'] == 000003) {
                return [
                    'sku' => $items['sku'],
                    'name' => $items['name'],
                    'category' => $items['category'],
                    'price' => array(
                        'original' => $items['price'],
                        'final' => ($items['price'] - $items['price'] * 15 / 100),
                        'discount_percentage' => "15%",
                        'currency' => 'EUR'
                    )
                ];
            } else {
                return [
                    'sku' => $items['sku'],
                    'name' => $items['name'],
                    'category' => $items['category'],
                    'price' => array(
                        'original' => $items['price'],
                        'final' => $items['price'],
                        'discount_percentage' => null,
                        'currency' => 'EUR'
                    )
                ];
            }
        });

        return $this->response;
    }

    public function categoryFilterData(array $data, string $category_name)
    {

        foreach ($this->withoutFilterData($data) as $key => $value) {
            if ($value['category'] == $category_name) {
                $this->response[] = $value;
            }
        }
        return $this->response;
    }

    public function priceFilterData(array $data, $price_min, $price_max)
    {
        foreach ($this->withoutFilterData($data) as $key => $value) {
            if ($value['price']['original'] >= $price_min && $value['price']['original'] <= $price_max) {
                $this->response[] = $value;
            }
        }
        return $this->response;
    }

    public function categoryAndPriceFilterData(array $data, $category_name, $price_min, $price_max)
    {

        foreach ($this->withoutFilterData($data) as $key => $value) {
            if ($value['price']['original'] >= $price_min && $value['price']['original'] <= $price_max && $value['category'] == $category_name) {
                $this->response[] = $value;
            }
        }
        return $this->response;
    }
}
