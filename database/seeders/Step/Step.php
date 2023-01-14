<?php

namespace Database\Seeders\Step;

use App\Models\Step as ModelsStep;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Step extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $files = fopen(base_path('database/seeders/Step/tahapan.csv'), "r");

        $firstLine = true;

        while (($data = fgetcsv($files, 520, ",")) !== false) {
            if (!$firstLine) {
                ModelsStep::create([
                    "name" => $data['2'],
                    "code" => $data['1'],
                ]);
            }
            $firstLine = false;
        }

        fclose($files);
    }
}
