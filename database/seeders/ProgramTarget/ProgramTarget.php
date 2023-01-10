<?php

namespace Database\Seeders\ProgramTarget;

use App\Models\ProgramTarget as ModelsProgramTarget;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProgramTarget extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $files = fopen(base_path('database/seeders/ProgramTarget/renaksi_target.csv'), "r");

        $firstLine = true;

        while (($data = fgetcsv($files, 520, ",")) !== false) {
            if (!$firstLine) {
                ModelsProgramTarget::create([
                    "year" => $data['2'],
                    "month" => $data['1'],
                    "day" => 30,
                    "name" => $data['4'],
                    "status_id" => 4,
                    "program_id" => $data['3'],
                ]);
            }
            $firstLine = false;
        }

        fclose($files);
    }
}
