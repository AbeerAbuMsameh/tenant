<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    use HasFactory , SoftDeletes;

    protected $guarded=[];

    public function members()
    {
        return $this->hasMany(Member::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function ticketTags()
    {
        return $this->hasMany(TicketTag::class);
    }

}
