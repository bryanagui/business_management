<?php

namespace Database\Seeders;

use App\Models\CouponCode;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CouponCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CouponCode::create([
            'name' => 'MAHALKITASANA',
            'discount' => 50,
            'valid_start' => new Carbon('December 29, 1996'),
            'valid_end' => new Carbon('December 29, 2050'),
        ]);
    }
}
