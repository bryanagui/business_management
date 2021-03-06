<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => 'Administrator']);
        Role::create(['name' => 'Twice']);
        Role::create(['name' => 'Super Manager']);
        Role::create(['name' => 'Manager']);
        Role::create(['name' => 'Staff']);
    }
}
