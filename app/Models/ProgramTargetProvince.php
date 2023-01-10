<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramTargetProvince extends Model
{

    protected $fillable = ['program_target_id', 'province_id'];

    use HasFactory;
}
