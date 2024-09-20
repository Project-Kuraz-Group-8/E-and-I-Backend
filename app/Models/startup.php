<?php

namespace App\Models;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Startup extends Model
{
    use HasFactory, Searchable;
    public function toSearchableArray(): Array
    {
        return ['title' => $this->title, 'category' => $this->category];
    }
}
