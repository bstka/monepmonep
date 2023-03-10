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
        $files = fopen(base_path('database/seeders/UnitOfMeasurement/units.csv'), "r");

        $firstLine = false;

        while (($data = fgetcsv($files, 520, ",")) !== false) {
            if (!$firstLine) {
                ModelsUnitOfMeasurement::create([
                    "name" => $data['0']
                ]);
            }
            $firstLine = false;
        }

        fclose($files);
    }
}
