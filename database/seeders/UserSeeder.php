<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Default credentials
        User::create([
            'name' => 'Bryan Joseph Aguinaldo',
            'email' => 'bryanjoseph.aguinaldo.e@bulsu.edu.ph',
            'email_verified_at' => now(),
            'password' => Hash::make('iloveusana'),
            'gender' => 'male',
            'birthdate' => new Carbon("June 26, 2001"),
            'address' => 'Malolos, Bulacan',
            'contact' => '09157700303',
            'photo' => 'bryan-default.jpg',
            'remember_token' => Str::random(10),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ])->assignRole(['Administrator']);

        User::create([
            'name' => 'Minatozaki Sana',
            'email' => 'sana.twice@jype.com',
            'email_verified_at' => now(),
            'password' => Hash::make('iloveusana'),
            'gender' => 'female',
            'birthdate' => new Carbon("December 29, 1996"),
            'address' => 'Seoul, South Korea',
            'contact' => '09123456789',
            'photo' => 'sana-default.jpg',
            'remember_token' => Str::random(10),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ])->assignRole(['Twice']);

        User::create([
            'name' => 'Hirai Momo',
            'email' => 'momo.twice@jype.com',
            'email_verified_at' => now(),
            'password' => Hash::make('iloveumomo'),
            'gender' => 'female',
            'birthdate' => new Carbon("November 9, 1996"),
            'address' => 'Seoul, South Korea',
            'contact' => '09123456789',
            'photo' => 'momo-default.jpg',
            'remember_token' => Str::random(10),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ])->assignRole(['Twice']);

        User::create([
            'name' => 'Myoui Mina',
            'email' => 'mina.twice@jype.com',
            'email_verified_at' => now(),
            'password' => Hash::make('iloveumina'),
            'gender' => 'female',
            'birthdate' => new Carbon("March 24, 1997"),
            'address' => 'Seoul, South Korea',
            'contact' => '09123456789',
            'photo' => 'mina-default.jpg',
            'remember_token' => Str::random(10),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ])->assignRole(['Twice']);

        User::create([
            'name' => 'Kim Dahyun',
            'email' => 'dahyun.twice@jype.com',
            'email_verified_at' => now(),
            'password' => Hash::make('iloveudahyun'),
            'gender' => 'female',
            'birthdate' => new Carbon("May 28, 1998"),
            'address' => 'Seoul, South Korea',
            'contact' => '09123456789',
            'photo' => 'dahyun-default.jpg',
            'remember_token' => Str::random(10),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ])->assignRole(['Twice']);

        User::create([
            'name' => 'Im Nayeon',
            'email' => 'nayeon.twice@jype.com',
            'email_verified_at' => now(),
            'password' => Hash::make('iloveunayeon'),
            'gender' => 'female',
            'birthdate' => new Carbon("September 22, 1995"),
            'address' => 'Seoul, South Korea',
            'contact' => '09123456789',
            'photo' => 'nayeon-default.jpg',
            'remember_token' => Str::random(10),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ])->assignRole(['Twice']);

        User::create([
            'name' => 'Son Chaeyoung',
            'email' => 'chaeyoung.twice@jype.com',
            'email_verified_at' => now(),
            'password' => Hash::make('iloveuchaeyoung'),
            'gender' => 'female',
            'birthdate' => new Carbon("April 23, 1999"),
            'address' => 'Seoul, South Korea',
            'contact' => '09123456789',
            'photo' => 'chaeyoung-default.jpg',
            'remember_token' => Str::random(10),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ])->assignRole(['Twice']);

        User::create([
            'name' => 'Park Jihyo',
            'email' => 'jihyo.twice@jype.com',
            'email_verified_at' => now(),
            'password' => Hash::make('iloveujihyo'),
            'gender' => 'female',
            'birthdate' => new Carbon("February 1, 1997"),
            'address' => 'Seoul, South Korea',
            'contact' => '09123456789',
            'photo' => 'jihyo-default.jpg',
            'remember_token' => Str::random(10),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ])->assignRole(['Twice']);

        User::create([
            'name' => 'Chou Tzuyu',
            'email' => 'tzuyu.twice@jype.com',
            'email_verified_at' => now(),
            'password' => Hash::make('iloveyoutzuyu'),
            'gender' => 'female',
            'birthdate' => new Carbon("June 14, 1999"),
            'address' => 'Seoul, South Korea',
            'contact' => '09123456789',
            'photo' => 'tzuyu-default.jpg',
            'remember_token' => Str::random(10),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ])->assignRole(['Twice']);

        User::create([
            'name' => 'Yoo Jeongyeon',
            'email' => 'jeongyeon.twice@jype.com',
            'email_verified_at' => now(),
            'password' => Hash::make('iloveujeongyeon'),
            'gender' => 'female',
            'birthdate' => new Carbon("November 1, 1996"),
            'address' => 'Seoul, South Korea',
            'contact' => '09123456789',
            'photo' => 'jeongyeon-default.jpg',
            'remember_token' => Str::random(10),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ])->assignRole(['Twice']);
    }
}
