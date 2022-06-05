<?php

namespace App\Services;

use App\Models\Product;
use App\Repositories\ProductRepo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ProductService extends BaseService
{
    /**
     * @var ProductRepo
     */
    private $productRepo;

    /**
     * ProductService constructor.
     */
    public function __construct()
    {
        $this->productRepo = new ProductRepo(Product::class);
    }

    /**
     * Get product listing
     *
     * @param $request
     * @return JsonResponse
     */
    public function getProducts($request): JsonResponse
    {
        try {
            $products = $this->productRepo->getProducts($request);
            if ($products->isNotEmpty()) {
                $this->productCollection($products);
                $response = $this->productResponse($products);
                return $this->response($response,'Products get successfully!');
            }
            return $this->response(null, 'Products not found.');

        } catch (\Exception $e) {
            return $this->response(null, $e->getMessage(), 'ERROR',
                Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Transform the Product Collection
     *
     * @param $products
     * @return void
     */
    private function productCollection($products)
    {
        $products->getCollection()->transform(function($product) {
            $category = $product->category;
            $categoryName = $category->name;
            $productDiscount = $categoryDiscount = 0;
            if ($category->discount) {
                $categoryDiscount = $category->discount->value;
            }
            if ($product->discount) {
                $productDiscount = $product->discount->value;
            }
            $discount = $this->getDiscount($product->price, $productDiscount, $categoryDiscount);
            return $this->productData($product, $categoryName, $discount);
        });
    }

    /**
     * Calculate the Discount of product and category
     * Apply the biggest discount
     *
     * @param int $price
     * @param int $productDiscount
     * @param int $categoryDiscount
     * @return array
     */
    private function getDiscount(int $price, int $productDiscount, int $categoryDiscount): array
    {
        $discountedValue = null;
        $discountedPrice = $price;
        if ($productDiscount > $categoryDiscount) {
            $discountedPrice = round($price - (($price*$productDiscount) / 100));
            $discountedValue = $productDiscount;
        } elseif ($categoryDiscount > $productDiscount) {
            $discountedPrice = round($price - (($price*$categoryDiscount) / 100));
            $discountedValue = $categoryDiscount;
        }

        return [
            'discountedPrice' => $discountedPrice,
            'discountValue' => $discountedValue ? $discountedValue.'%' : null
        ];
    }

    /**
     * Prepare the product data
     *
     * @param Product $product
     * @param string $categoryName
     * @param array $discount
     * @return array
     */
    private function productData(Product $product, string $categoryName, array $discount): array
    {
        return array_merge($product->toArray(), [
            'category'  => $categoryName,
            'price'     => [
                'original'              => $product->price,
                'final'                 => $discount['discountedPrice'],
                'discount_percentage'   => $discount['discountValue'],
                'currency'              => $product->currency
            ]
        ]);
    }

    /**
     * Create the product & pagination response
     *
     * @param $products
     * @return array
     */
    private function productResponse($products): array
    {
        return [
            'products'   => $products->items(),
            'pagination' => [
                'total'        => $products->total(),
                'per_page'     => $products->perPage(),
                'current_page' => $products->currentPage(),
                'last_page'    => $products->lastPage(),
                'from'         => $products->firstItem(),
                'to'           => $products->lastItem()
            ]
        ];
    }
}
