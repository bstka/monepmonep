<?php

namespace Database\Seeders\ProgramQuantitative;

use App\Models\ProgramQuantitative;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Quantitative extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $files = fopen(base_path('database/seeders/ProgramQuantitative/ProgramQuantitative.csv'), "r");

        $firstLine = true;

        while (($data = fgetcsv($files, 520, ",")) !== false) {
            if (!$firstLine) {
                ProgramQuantitative::create([
                    "program_id" => $data['0'],
                    "unit_id" => $data['5'],
                    "quantitative" => $data['2'],
                    "year" => $data['3'],
                ]);
            }
            $firstLine = false;
        }

        fclose($files);
    }
}
