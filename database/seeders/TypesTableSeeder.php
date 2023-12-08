<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class TypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Array of common RV types
        $types = [
            'Class A',
            'Class B',
            'Class C',
            'Camper Van',
            'Folding Trailer',
            'Travel Trailer',
            'Fifth Wheel',
            'Toy Hauler',
            'Truck Camper',
            'Destination travel trailer'
            // Add more types as needed
        ];

        // Insert data into the 'types' table
        foreach ($types as $type) {
            DB::table('types')->insert([
                'name' => $type,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
