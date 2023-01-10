<?php

namespace Database\Seeders\City;

use App\Models\Administration\City as ModelsCity;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class City extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $files = fopen(base_path('database/seeders/City/regencies.csv'), "r");

        $firstLine = true;

        while (($data = fgetcsv($files, 520, ",")) !== false) {
            if (!$firstLine) {
                ModelsCity::create([
                    "name" => $data['2'],
                    "code" => $data['0'],
                    "province_id" => $data['1']
                ]);
            }
            $firstLine = false;
        }

        fclose($files);
    }
}
