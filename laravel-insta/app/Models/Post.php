<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    public function user(){
        return $this->belongsTo(User::class)->withTrashed();
        //A post belongs to a user
        //To get the owner of the post
    }

    public function categoryPost(){
        return $this->hasMany(CategoryPost::class);

        // To get categories under a post
        //Post->CategoryPost
    }

    public function comments(){
        return $this->hasMany(Comment::class);
        // A post has many comments
        // To retreive all the comments associated with a post
    }

    public function likes(){
        return $this->hasMany(Like::class);
        // Post -Like
        // To get all the likes of a post
    }

    public function isLiked(){
        return $this->likes()->where('user_id', Auth::user()->id)->exists();
        #Return True if the Auth user already liked 
    }

}
