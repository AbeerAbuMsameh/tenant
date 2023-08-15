<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Conjunction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['conjunction', 'output_field', 'output_value'];
}
