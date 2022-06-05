<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    /**
     * @var ProductService
     */
    private $_productService;

    /**
     * ProductController constructor.
     */
    public function __construct(ProductService $productService)
    {
        $this->_productService = $productService;
    }

    /**
     * Get product listing
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getProducts(Request $request): JsonResponse
    {
        return $this->_productService->getProducts($request->all());
    }
}
