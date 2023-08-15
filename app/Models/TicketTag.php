<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TicketTag extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ticket_tags';
    protected $fillable = [
        'words',
        'team_id',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
