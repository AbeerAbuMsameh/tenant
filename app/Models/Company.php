<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory, SoftDeletes;

    protected $connection = 'mysql';

    protected $fillable = [
        'name',
        'email',
        'logo',
        'address',
        'phone',
        'website',
        'description',
        'active',
        'database_id',
        'server_id',
        'rate',
        'client_id',
    ];



    public function paymentPackages()
    {
        return $this->hasMany(CompanyPaymentPackage::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function server()
    {
        return $this->belongsTo(Server::class);
    }

    public function database()
    {
        return $this->belongsTo(Database::class);
    }

}
