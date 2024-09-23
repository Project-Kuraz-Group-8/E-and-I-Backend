<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Investor extends Model
{
    use HasFactory, Searchable;
    protected $fillable = [
        'user_id',
        'investment_experience',
        'investment_interest',
        'company_description',
    ];
    public function toSearchableArray(): Array
    {
        return [
            'investment_experience' => $this->investment_experience, 
            'investment_interest' => $this->investment_interest
        ];
    }
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
