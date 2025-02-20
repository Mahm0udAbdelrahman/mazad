<?php

namespace Database\Seeders;

use App\Models\CarType;
use App\Models\CartType;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CarTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $carTypes = [
            "Acura",
            "Alfa Romeo",
            "Audi",
            "BMW",
            "Buick",
            "Cadillac",
            "Chevrolet",
            "Chrysler",
            "Dodge",
            "Fiat",
            "Ford",
            "Genesis",
            "GMC",
            "Honda",
            "Hyundai",
            "Infiniti",
            "Jaguar",
            "Jeep",
            "Kia",
            "Land Rover",
            "Lexus",
            "Lincoln",
            "Mazda",
            "McLaren",
            "Mercedes-Benz",
            "Mini",
            "Mitsubishi",
            "Nissan",
            "Porsche",
            "Ram",
            "Subaru",
            "Tesla",
            "Toyota",
            "Volkswagen",
            "Volvo"
        ];

        foreach ($carTypes as $type) {
            CarType::create(['name' => $type]);
        }
    }
}
