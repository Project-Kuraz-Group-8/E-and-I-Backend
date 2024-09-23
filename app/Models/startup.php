<?php

namespace App\Models;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Startup extends Model
{
    use HasFactory, Searchable;
    protected $fillable = ['title','description','team_members','category','goal_amount','current_amount','status', 'user_id'];
    public function toSearchableArray(): Array
    {
        return ['title' => $this->title, 'category' => $this->category, 'status' => $this->status, 'goal_amount' => $this->goal_amount];
    }
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
