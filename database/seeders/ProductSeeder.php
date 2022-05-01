<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::create([
            'category' => 'K-Pop Albums',
            'name' => 'Formula of Love O+T=<3',
            'price' => 250000,
            'stock' => 100,
        ]);
    }
}
