<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    // Define role ID Admin = 1, User = 2

    const ADMIN_ROLE_ID = 1; // Admin role identifier
    const USER_ROLE_ID = 2; // User role identifier
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function posts(){
        return $this->hasMany(Post::class)->latest();
        // This method indicates thats a user can have many associated posts
    }

    public function followers(){
        return $this->hasMany(Follow::class, 'following_id');
        // to get the followers of a user
    }

    public function following(){
        return $this->hasMany(Follow::class, 'follower_id');
        // to get the users that the user is following
    }

    public function isFollowed(){
        return $this->followers()->where('follower_id', Auth::user()->id)->exists();
        // Auth::user()->id is the follower_id
        // Firstly, get all the followers of a User($this->followers()). Then, from that list, search for the Auth user from the follower colum(where('follower_id', Auth::user()->id))
    }
}
