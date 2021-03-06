<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Room::factory()->count(120)->create();
        // Room::create([
        //     'number' => 1001,
        //     'floor' => 1,
        //     'type' => 'Studio',
        //     'description' => 'Can handle a maximum of 2 persons.',
        //     'rate' => 250000,
        // ]);
    }
}
