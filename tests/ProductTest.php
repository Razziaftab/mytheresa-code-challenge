<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class ProductTest extends TestCase
{

    /**
     * /products [GET]
     */
    public function testShouldReturnAllProducts(){

        $this->get("api/products", []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'status',
            'message',
            'data' => [
                'products' => ['*' =>
                    [
                        'sku',
                        'name',
                        'category',
                        'price' => [
                            'original',
                            'final',
                            'discount_percentage',
                            'currency'
                        ]
                    ]
                ]
            ]
        ]);
    }

    /**
     * /products with category filter [GET]
     */
    public function testCategoryFilterProducts(){

        $this->get("api/products?category=boots", []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'status',
            'message',
            'data' => [
                'products' => ['*' =>
                    [
                        'sku',
                        'name',
                        'category',
                        'price' => [
                            'original',
                            'final',
                            'discount_percentage',
                            'currency'
                        ]
                    ]
                ]
            ]
        ]);
    }

    /**
     * /products with priceLessThan filter [GET]
     *
     * @return void
     */
    public function testPriceLessThanFilterProducts(){

        $this->get("api/products?priceLessThan=10000", []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'status',
            'message',
            'data' => [
                'products' => ['*' =>
                    [
                        'sku',
                        'name',
                        'category',
                        'price' => [
                            'original',
                            'final',
                            'discount_percentage',
                            'currency'
                        ]
                    ]
                ]
            ]
        ]);
    }


    /**
     * /products with category & priceLessThan filter [GET]
     *
     * @return void
     */
    public function testCategoryAndPriceLessThanFilterProducts(){

        $this->get("api/products?category=boots&priceLessThan=30000", []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'status',
            'message',
            'data' => [
                'products' => ['*' =>
                    [
                        'sku',
                        'name',
                        'category',
                        'price' => [
                            'original',
                            'final',
                            'discount_percentage',
                            'currency'
                        ]
                    ]
                ]
            ]
        ]);
    }

    /**
     * /products Not found [GET]
     *
     * @return void
     */
    public function testProductNotFound(){

        $this->get("api/products?category=boots&priceLessThan=1000", []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'status',
            'message',
            'data'
        ]);
    }
}
