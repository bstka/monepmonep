<?php

namespace Database\Seeders\Status;

use App\Models\Status as ModelsStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Status extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $files = fopen(base_path('database/seeders/Status/status.csv'), "r");

        $firstLine = true;

        while (($data = fgetcsv($files, 520, ",")) !== false) {
            if (!$firstLine) {
                ModelsStatus::create([
                    "color" => $data['1'],
                    "name" => $data['2'],
                    "code" => $data['0'],
                ]);
            }
            $firstLine = false;
        }

        fclose($files);
    }
}
