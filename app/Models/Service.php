<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name'];

    public function service_systems()
    {
        return $this->hasMany(ServiceSystem::class);
    }

    public function getSortedServiceSystemsAttribute()
    {
        return $this->serviceSystems()->orderBy('sort_num')->get();
    }

}
