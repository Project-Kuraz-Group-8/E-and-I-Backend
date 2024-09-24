<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    public function conversations(){
        return $this->hasMany(Conversation::class, "sender_id")->orWhere('receiver_id', $this->id);

    }

    public static function getUsersExceptUser(User $user){
        $userId = $user->id;
        $query = User::select('users.*')->where('users.id', '!=', $userId)
                                        ->leftjoin('conversations', function ($join) use ($userId){
                                            $join->on('conversations.sender_id', '=', 'users.id')
                                                    ->where('conversations.receiver_id', '=', $userId)
                                                    ->orWhere(function($query) use ($userId){
                                                        $query->on('conversations.receiver_id', '=', 'users.id')
                                                             ->where('conversations.sender_id', '=', $userId);

                                                    });
                                        })->whereNotNull('conversations.id') 
                                        ->leftjoin('messages', 'messages.id', '=', 'conversations.last_message_id')
                                          ->orderBy('messages.created_at', 'desc')
                                          ->orderBy('users.name');

        return $query->get();

    }
}
