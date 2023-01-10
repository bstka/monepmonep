<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramTargetFileProvinces extends Model
{
    use HasFactory;

    protected $fillable = ['province_id', 'target_file_id'];

    public function files()
    {
        return $this->belongsTo(ProgramTargetFiles::class, 'id');
    }
}
