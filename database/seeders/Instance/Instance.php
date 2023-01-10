<?php

namespace Database\Seeders\Instance;

use App\Models\Instance as ModelsInstance;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Instance extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $files = fopen(base_path('database/seeders/Instance/instansi.csv'), "r");

        $firstLine = false;

        while (($data = fgetcsv($files, 520, ",")) !== false) {
            if (!$firstLine) {
                ModelsInstance::create([
                    "name" => $data['2'],
                    "code" => $data['1'],
                ]);
            }
            $firstLine = false;
        }

        fclose($files);
    }
}
