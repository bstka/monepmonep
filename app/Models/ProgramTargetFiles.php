<?php

namespace App\Models;

use App\Models\Administration\Province;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgramTargetFiles extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'compilation_doc',
        'integration_doc',
        'compilation_target_count',
        'integration_target_count',
        'syncronization_target_count',
        'publication_target_count',
        'compilation_value',
        'integration_value',
        'syncronization_value',
        'publication_value',
        'program_target_id',
        'description',
        'reported_by_user_id',
        'validated_by_setkab_id',
        'validated_by_satgas_id',
        'validated_by_setkab_timestamp',
        'validated_by_satgas_timestamp',
        'validate_note_setkab',
        'validate_note_satgas'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'reported_by_user_id');
    }

    public function target()
    {
        return $this->belongsTo(ProgramTarget::class);
    }

    public function provinces()
    {
        return $this->hasManyThrough(Province::class, ProgramTargetFileProvinces::class, 'target_file_id', 'id', null, "province_id");
    }
}
