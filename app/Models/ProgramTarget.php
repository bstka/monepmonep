<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Administration\Province;

class ProgramTarget extends Model
{
    use HasFactory;

    public function files()
    {
        return $this->hasMany(ProgramTargetFiles::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function provinces()
    {
        return $this->hasManyThrough(Province::class, ProgramTargetProvince::class, 'province_id', 'id');
    }

    public function programQuantitative()
    {
        return $this->belongsTo(ProgramQuantitative::class);
    }
}
