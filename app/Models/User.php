<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'mobile',
        'password',
        'role',
        'username',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    /**
     * Get all of the notifications for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class, 'user_id');
    }
    /**
     * Get all of the sent_messages for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sent_messages(): HasMany
    {
        return $this->hasMany(Message::class, 'sender_id');
    }
    /**
     * Get all of the received_messages for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function received_messages(): HasMany
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }
    /**
     * Get all of the programs for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function programs(): HasMany
    {
        return $this->hasMany(Program::class, 'trainer_id');
    }
}
