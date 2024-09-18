<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class startup extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'title',
        'description',
        'funding_stage',
        'team_members',
        'pitch_deck_url',
        'business_plan_url',
        'current_amount',
        'goal_amount',
        'category',
        'visibility',
        'status'
    ];
    

    // Relationship to User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
