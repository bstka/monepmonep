<?php

namespace Database\Seeders\ProgramRelatedInstance;

use App\Models\ProgramRelatedInstance;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RelatedInstance extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $files = fopen(base_path('database/seeders/ProgramRelatedInstance/related_instance.csv'), "r");

        $firstLine = true;

        while (($data = fgetcsv($files, 520, ",")) !== false) {
            if (!$firstLine) {
                ProgramRelatedInstance::create([
                    "instance_id" => $data['0'],
                    "program_id" => $data['1'],
                ]);
            }
            $firstLine = false;
        }

        fclose($files);
    }
}
