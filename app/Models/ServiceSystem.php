<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceSystem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'service_id',
        'system_id',
        'tier_id',
        'main_host',
        'sort_num',
        'command',
        'created_at',
    ];

    public function system()
    {
        return $this->belongsTo(System::class);
    }

    public function tier()
    {
        return $this->belongsTo(Tier::class);
    }
}
