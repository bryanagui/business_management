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
            'price' => 108800,
            'stock' => 100,
            'media' => 'bHF9qNQLKB4LHv2EXIsv5q4B8wgXOt.jpg'
        ]);

        Product::create([
            'category' => 'K-Pop Albums',
            'name' => 'TWICE 9TH MINI ALBUM: MORE & MORE',
            'price' => 107000,
            'stock' => 100,
            'media' => '1HhjhcRd0GUzXwQxqqGlf1xHvbJjmF.jpg'
        ]);

        Product::create([
            'category' => 'K-Pop Albums',
            'name' => 'TWICE 4TH WORLD TOUR III: SEOUL BLURAY',
            'price' => 223800,
            'stock' => 100,
            'media' => '2ZlahxOHGIMA18J5Wgh8UlDCSRKYHw.jpg'
        ]);

        Product::create([
            'category' => 'K-Pop Albums',
            'name' => 'TWICE 4TH WORLD TOUR III: SEOUL DVD  ',
            'price' => 198700,
            'stock' => 100,
            'media' => 'ejCzP9TxUVAGNImNPf2lVL6aZ3iQt9.jpg'
        ]);
    }
}
