<?php

namespace Database\Seeders\UnitOfMeasurement;

use App\Models\UnitOfMeasurement as ModelsUnitOfMeasurement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitOfMeasurement extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ModelsUnitOfMeasurement::create([
            "name" => "Satuan"
        ]);
    }
}
