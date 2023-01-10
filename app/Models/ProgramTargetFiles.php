<?php

namespace App\Models;

use App\Models\Administration\Province;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramTargetFiles extends Model
{
    use HasFactory;

    protected $fillable = [
        '*', 'compilation_doc',
        'integration_doc',
        'compilation_target_count',
        'integration_target_count',
        'syncronization_target_count',
        'publication_target_count',
        'program_target_id',
        'description'
    ];

    public function target()
    {
        return $this->belongsTo(ProgramTarget::class);
    }

    public function provinces()
    {
        return $this->hasManyThrough(Province::class, ProgramTargetFileProvinces::class, 'target_file_id', 'id', null, "province_id");
    }
}
