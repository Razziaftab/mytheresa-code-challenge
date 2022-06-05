<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Repositories\CategoryRepo;
use App\Repositories\ProductRepo;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{

    /**
     * @var Generator
     */
    private $faker;

    /**
     * @var ProductRepo
     */
    private $productRepo;

    /**
     * @var CategoryRepo
     */
    private $categoryRepo;

    /**
     * ProductTableSeeder constructor.
     */
    public function __construct()
    {
        $this->faker = Factory::create();
        $this->categoryRepo = new CategoryRepo(Category::class);
        $this->productRepo = new ProductRepo(Product::class);
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->productRepo->truncate();
        $this->productData();
    }

    /**
     * Insert Product Data.
     *
     * @return void
     */
    private function productData()
    {
        $categories = $this->categoryRepo->all();
        if ($categories->isNotEmpty()) {
            $productData = [];
            $sku = 1;
            foreach ($categories as $category) {
                for ($i = 0; $i < 10; $i++) {
                    $productData[] = [
                        'sku'           => str_pad($sku, 6, '0', STR_PAD_LEFT),
                        'name'          => $this->faker->name,
                        'category_id'   => $category->id,
                        'price'         => $this->faker->numberBetween(1000, 99999),
                        'currency'      => 'EUR',
                    ];
                    $sku++;
                }
            }
            $this->productRepo->insert($productData);
        }
    }
}
