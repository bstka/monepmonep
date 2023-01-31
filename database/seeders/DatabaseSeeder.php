<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\City\City;
use Database\Seeders\Instance\Instance;
use Database\Seeders\Program\Program;
use Database\Seeders\ProgramQuantitative\Quantitative;
use Database\Seeders\ProgramRelatedInstance\RelatedInstance;
use Database\Seeders\ProgramTarget\ProgramTarget;
use Database\Seeders\Province\Province;
use Database\Seeders\Status\Status;
use Database\Seeders\Step\Step;
use Database\Seeders\SubStep\SubStep;
use Database\Seeders\UnitOfMeasurement\UnitOfMeasurement;
use Database\Seeders\User\UserAndRoles;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(Province::class);
        $this->call(City::class);
        $this->call(Instance::class);
        $this->call(Step::class);
        $this->call(SubStep::class);
        $this->call(Status::class);
        $this->call(UnitOfMeasurement::class);
        $this->call(Program::class);
        $this->call(Quantitative::class);
        // $this->call(ProgramTarget::class);
        // $this->call(RelatedInstance::class);
        $this->call(UserAndRoles::class);
    }
}
