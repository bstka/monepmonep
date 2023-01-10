<?php

namespace Database\Seeders\Program;

use App\Models\Program as ModelsProgram;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Program extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $files = fopen(base_path('database/seeders/Program/renaksi2.csv'), "r");

        $firstLine = true;

        while (($data = fgetcsv($files, 520, ",")) !== false) {
            if (!$firstLine) {
                ModelsProgram::create([
                    "name" => $data['2'],
                    "code" => $data['3'],
                    "event" => $data['4'],
                    "output" => $data['5'],
                    "value" => '-',
                    "instance_id" => $data['6'],
                    "unit_id" => 1,
                    "status_id" => 4,
                    "step_id" => $data['0'],
                    "sub_step_id" => $data['1'],
                ]);
            }
            $firstLine = false;
        }

        fclose($files);
    }
}
