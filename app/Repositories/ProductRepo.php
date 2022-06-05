<?php

namespace App\Repositories;

class ProductRepo extends BaseRepo
{
    /**
     * @param $model
     */
    public function __construct($model)
    {
        parent::__construct($model);
    }

    /**
     * Get Random Products
     * Where sku is not equal to 000003
     *
     * @return mixed
     */
    public function getRandomProduct()
    {
        return $this->model->where('sku', '<>', 000003)->inRandomOrder()->limit(5)->get();
    }

    /**
     * Get product with category
     *
     * @param $request
     * @return mixed
     */
    public function getProducts($request)
    {
        $product = $this->model;

        $priceLessThan = $request['priceLessThan'] ?? null;
        $category = $request['category'] ?? null;

        $product = $product->with(['category']);

        if ($priceLessThan)
            $product = $product->where('price', '<', $priceLessThan);

        if ($category) {
            $product->whereHas('category', function ($q) use($category) {
                $q->where('name', $category);
            });
        }

        $product->orderBy('updated_at', 'desc');
//        $product = $product->get();
        return $product->paginate(10);
    }
}
