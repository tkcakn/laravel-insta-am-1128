<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Follow;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    private $follow;

    public function __construct(Follow $follow)
    {
        $this->follow = $follow;
    }

    public function store($user_id){
        // The Auth user is the follower, The Auth user is the one create the action to follow a user
        $this->follow->follower_id = Auth::user()->id;
        $this->follow->following_id = $user_id;
        $this->follow->save();

        return back();
    }

    public function destroy($user_id){
        $this->follow->where('follower_id', Auth::user()->id)
        ->where('following_id', $user_id)
        ->delete();

        return back();
    }
}
