<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $types = ["Single", "Double", "Quad", "Studio", "Junior", "Queen", "King", "Master", "Executive", "Presidential"];
        $number = 0;
        $floor = 0;
        $description = "";
        $randomType = $types[array_rand($types)];
        $ratePerType = 0;

        switch ($randomType) {
            case 'Single':
                $floor = rand(0, 5);
                $number = rand(1000, 5100);
                $description = "A standard room perfect for one solo person.";
                $ratePerType = 150000;
                break;
            case 'Double':
                $floor = rand(4, 9);
                $number = rand(4000, 9100);
                $description = "A standard room perfect for two people accomodation.";
                $ratePerType = 175000;
                break;
            case 'Quad':
                $floor = rand(7, 12);
                $number = rand(7000, 12100);
                $description = "A standard family room.";
                $ratePerType = 225000;
                break;
            case 'Studio':
                $floor = rand(10, 15);
                $number = rand(10000, 15100);
                $description = "A studio family room.";
                $ratePerType = 270000;
                break;
            case 'Junior':
                $floor = rand(14, 18);
                $number = rand(14000, 18100);
                $description = "A small-sized room to accomodate up to four people.";
                $ratePerType = 325000;
                break;
            case 'Queen':
                $floor = rand(18, 22);
                $number = rand(18000, 22100);
                $description = "A queen-sized room to accomodate up to five people.";
                $ratePerType = 400000;
                break;
            case 'King':
                $floor = rand(22, 25);
                $number = rand(22000, 25100);
                $description = "A king-sized room to accomodate up to six people.";
                $ratePerType = 500000;
                break;
            case 'Master':
                $floor = rand(26, 28);
                $number = rand(26000, 28100);
                $description = "A master-sized room complete with facilities.";
                $ratePerType = 750000;
                break;
            case 'Executive':
                $floor = rand(28, 30);
                $number = rand(28000, 30100);
                $description = "A luxurious executive type room complete with facilities.";
                $ratePerType = 1000000;
                break;
            case 'Presidential':
                $floor = rand(29, 30);
                $number = rand(29000, 30200);
                $description = "A luxurious presidential type room, largest of all.";
                $ratePerType = 1250000;
                break;
        }

        return [
            'number' => $number,
            'floor' => $floor,
            'type' => $randomType,
            'description' => $description,
            'rate' => $ratePerType,
        ];
    }
}
