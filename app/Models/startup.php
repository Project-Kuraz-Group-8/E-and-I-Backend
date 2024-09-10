<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class startup extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'funding_stage',
        'team_members',
        'pitch_deck_url',
        'bussiness_plan_url',
        'goal_amount',
        'current_amount',
        'category',
        'visibility',
        'status'
    ];
}
