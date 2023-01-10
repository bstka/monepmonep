<?php

namespace Database\Seeders\Province;

use App\Models\Administration\Province as ModelsProvince;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Province extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $files = fopen(base_path('database/seeders/Province/provinces.csv'), "r");

        $firstLine = false;

        while (($data = fgetcsv($files, 520, ",")) !== false) {
            if (!$firstLine) {
                ModelsProvince::create([
                    "name" => $data['1'],
                    "code" => $data['0'],
                    "id" => $data['0']
                ]);
            }
            $firstLine = false;
        }

        fclose($files);
    }
}
