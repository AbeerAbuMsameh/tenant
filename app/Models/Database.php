<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Database extends Model
{
    use HasFactory;

    protected $connection = 'mysql';

    protected $fillable = ['host', 'username', 'password', 'database'];

    public function company()
    {
        return $this->hasMany(Company::class);
    }
}
