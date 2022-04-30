<?php

namespace Database\Seeders;

use App\Models\RoomType;
use Illuminate\Database\Seeder;

class RoomTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RoomType::create(['type' => 'Single']);
        RoomType::create(['type' => 'Double']);
        RoomType::create(['type' => 'Quad']);
        RoomType::create(['type' => 'Studio']);
        RoomType::create(['type' => 'Junior']);
        RoomType::create(['type' => 'Queen']);
        RoomType::create(['type' => 'King']);
        RoomType::create(['type' => 'Master']);
        RoomType::create(['type' => 'Executive']);
        RoomType::create(['type' => 'Presidential']);
    }
}
