<?php

namespace Database\Seeders\SubStep;

use App\Models\SubStep as ModelsSubStep;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubStep extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $files = fopen(base_path('database/seeders/SubStep/sub_tahapan.csv'), "r");

        $firstLine = true;

        while (($data = fgetcsv($files, 520, ",")) !== false) {
            if (!$firstLine) {
                $cast = [
                    "name" => $data['2'],
                    "code" => $data['1'],
                    "step_id" => (int)$data['0'],
                ];
                ModelsSubStep::create($cast);
            }
            $firstLine = false;
        }

        fclose($files);
    }
}
