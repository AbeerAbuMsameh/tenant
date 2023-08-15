<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use function Symfony\Component\Translation\t;

class Ticket extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'ticket_num',
        'report_date',
        'open_date',
        'assign_date',
        'last_resolve_date',
        'close_date',
        'tier1',
        'tier2',
        'tier3',
        'team_id',
        'report_src',
        'description',
        'impact',
        'urgency',
        'priority',
    ];

    protected $relationsFillable = [
        'team_id'   => 'team->name',
        'tier1'     => 'system->name'
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function system()
    {
        return $this->belongsTo(System::class, 'tier1');
    }


    public function applyRules()
    {
        $conjunctions = Conjunction::all();
        foreach ($conjunctions as $conjunction) {
            $conjunctionQuery = $conjunction->conjunction;
            foreach (array_diff($this->fillable, array_keys($this->relationsFillable)) as $field) {
                $conjunctionQuery = str_replace($field, '$this->'.$field, $conjunctionQuery);
            }
            foreach ($this->relationsFillable as $key => $value) {
                $conjunctionQuery = str_replace($key, '$this->'.$value, $conjunctionQuery);
            }

            $conjunctionQuery = str_replace('\r', '', $conjunctionQuery);
            $conjunctionQuery = str_replace('\n', '', $conjunctionQuery);
            $conjunctionQuery = preg_replace('/\s+/', ' ', $conjunctionQuery);

            try {
                if (eval("return $conjunctionQuery;")) {
                    $this->{$conjunction->output_field} = $conjunction->output_value;
                }
            } catch (\Exception $e) {
            }
        }
        $this->save();
    }


    public function assignTeamBasedOnTags()
    {
        $description = $this->description;
        $tags = TicketTag::all();
        $highestMatchCount = 0;
        $assignedTeamId = null;

        foreach ($tags as $tag) {
            $tagWords = explode(',', $tag->words);
            $matchCount = 0;
            foreach ($tagWords as $word) {
                if (Str::contains($description, $word)) {
                    $matchCount++;
                }
            }
            if ($matchCount > $highestMatchCount) {
                $highestMatchCount = $matchCount;
                $assignedTeamId = $tag->team_id;
            }
        }
        if ($assignedTeamId !== null) {
            $this->team_id = $assignedTeamId;
            $this->save();
        }
    }
}
