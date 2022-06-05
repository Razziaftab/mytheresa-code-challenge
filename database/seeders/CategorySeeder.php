<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Repositories\CategoryRepo;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{

    /**
     * @var CategoryRepo
     */
    private $categoryRepo;

    /**
     * CategoryTableSeeder constructor.
     */
    public function __construct()
    {
        $this->categoryRepo = new CategoryRepo(Category::class);
    }


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->categoryRepo->truncate();
        $this->CategoryData();
    }

    /**
     * Insert Category Data.
     *
     * @return void
     */
    private function CategoryData(): void
    {
        $categoryData = [
            [
                'name' => 'boots',
            ],
            [
                'name' => 'sandals',
            ],
            [
                'name' => 'sneakers',
            ],
            [
                'name' => 'loafers',
            ],
            [
                'name' => 'slippers',
            ]
        ];
        $this->categoryRepo->insert($categoryData);
    }
}
