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
        Room::create([
            'number' => 1001,
            'floor' => 1,
            'type' => 'Standard',
            'description' => 'Default room for testing purposes.',
            'rate' => 500000,
        ]);
    }
}
