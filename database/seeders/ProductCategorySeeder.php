<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductCategory::create(['name' => 'Room Additionals']);
        ProductCategory::create(['name' => 'K-Pop Albums']);
        ProductCategory::create(['name' => 'Souvenirs']);
        ProductCategory::create(['name' => 'Alcoholic Beverages']);
        ProductCategory::create(['name' => 'Beverages']);
        ProductCategory::create(['name' => 'Snacks']);
        ProductCategory::create(['name' => 'Deserts']);
    }
}
