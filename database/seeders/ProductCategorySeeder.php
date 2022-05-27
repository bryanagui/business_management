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
        ProductCategory::create(['name' => 'K-Pop Albums']);
        ProductCategory::create(['name' => 'Light Sticks']);
        ProductCategory::create(['name' => 'Photobooks']);
        ProductCategory::create(['name' => 'Photocards']);
    }
}
