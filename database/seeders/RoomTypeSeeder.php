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
        RoomType::create(['type' => 'Studio']);
        RoomType::create(['type' => 'Murphy']);
        RoomType::create(['type' => 'King']);
        RoomType::create(['type' => 'Queen']);
        RoomType::create(['type' => 'Junior']);
        RoomType::create(['type' => 'Executive']);
        RoomType::create(['type' => 'Extended']);
        RoomType::create(['type' => 'Presidential']);
    }
}
