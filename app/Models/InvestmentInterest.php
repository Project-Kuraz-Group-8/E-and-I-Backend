<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvestmentInterest extends Model
{
    use HasFactory;
    protected $fillable = ['status'];
    protected $table = "project_investor_interests";
    
    public function startup() {
        return $this->belongsTo(Startup::class);
    }
    
    public function investor() {
        return $this->belongsTo(User::class, 'investor_id');
    }
}
