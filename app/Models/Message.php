<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'message',
        'sender_id',
        'receiver_id',
        'file'

    ];

    public function sender(){
        return $this->belongsToMany(User::class, 'sender_id');
    }

    public function reciever(){
        return $this->belongsToMany(User::class, 'reciever_id');
    }
}
