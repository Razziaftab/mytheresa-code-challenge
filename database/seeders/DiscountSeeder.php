<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Discount;
use App\Models\Product;
use App\Repositories\CategoryRepo;
use App\Repositories\DiscountRepo;
use App\Repositories\ProductRepo;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Database\Seeder;

class DiscountSeeder extends Seeder
{

    /**
     * @var Generator
     */
    private $faker;

    /**
     * @var CategoryRepo
     */
    private $categoryRepo;

    /**
     * @var ProductRepo
     */
    private $productRepo;

    /**
     * @var DiscountRepo
     */
    private $discountRepo;

    /**
     * DiscountTableSeeder constructor.
     */
    public function __construct()
    {
        $this->faker = Factory::create();
        $this->categoryRepo = new CategoryRepo(Category::class);
        $this->productRepo = new ProductRepo(Product::class);
        $this->discountRepo = new DiscountRepo(Discount::class);
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->discountRepo->truncate();
        $this->discountData();
    }

    /**
     * Insert Discount Data.
     * Discount for category and product
     *
     * @return void
     */
    private function discountData()
    {
        $discountData = [];
        $category = $this->categoryRepo->findByClause(['name' => 'boots'])->first();
        $products = $this->productRepo->getRandomProduct();
        $productSKU = $this->productRepo->findByClause(['sku' => 000003])->first();

        if ($category) {
            $discountData[] = [
                'value'             => 30,
                'discountable_type' => 'App\Models\Category',
                'discountable_id'   => $category->id,
            ];
        }

        if ($products->isNotEmpty()) {
            foreach ($products as $product) {
                $discountData[] = [
                    'value'             => $this->faker->numberBetween(05, 80),
                    'discountable_type' => 'App\Models\Product',
                    'discountable_id'   => $product->id,
                ];
            }
        }

        if ($productSKU) {
            $discountData[] = [
                'value' => 15,
                'discountable_type' => 'App\Models\Product',
                'discountable_id'   => $productSKU->id,
            ];
        }

        $this->discountRepo->insert($discountData);
    }
}
