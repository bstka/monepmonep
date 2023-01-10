<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;


    public function instance()
    {
        return $this->belongsTo(Instance::class);
    }

    public function relatedInstances()
    {
        return $this->hasManyThrough(Instance::class, ProgramRelatedInstance::class, 'program_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function step()
    {
        return $this->belongsTo(Step::class);
    }

    public function subStep()
    {
        return $this->belongsTo(SubStep::class);
    }

    public function targets()
    {
        return $this->hasMany(ProgramTarget::class, 'program_id');
    }

    public function unit()
    {
        return $this->belongsTo(UnitOfMeasurement::class);
    }
}
