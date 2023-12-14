<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use  App\Models\User;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    private $post;
    private $user;

    public function __construct(Post $post, User $user)
    {
        $this->post = $post;
        $this->user = $user;

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $home_posts = $this->getHomePosts();
        $suggested_users = $this->getSuggestedUsers();
        
        return view('users.home')->with('home_posts', $home_posts)
                                 ->with('suggested_users', $suggested_users);
    }

    // Get the post of the ysers that the Auth user is following
    public function getHomePosts(){
        $all_posts = $this->post->latest()->get();
        $home_posts = [];

        foreach($all_posts as $post){
            if($post->user->isFollowed() || $post->user->id == Auth::user()->id){
                $home_posts[] = $post;
            }
        }

        return $home_posts;
    }

    private function getSuggestedUsers(){
        // Get the users that the Auth user is not following
        $all_users = $this->user->all()->except(Auth::user()->id);

        $suggested_users = [];

        foreach($all_users as $user){
            if(!$user->isFollowed()){
                $suggested_users[] = $user;
            }
        }
        // return $suggested_users;
        return array_slice($suggested_users,0,5);
        // array_slice(x,y,z)
        // x --- array ->variable array
        // y --- offse ->starting index
        // Z --- length ->how many data to be displayed
        // returns an array containing the first 5 suggested users

    }

    public function search(Request $request){
        // Searches for users in the database whose 'name' partially matches the search term
        $users = $this->user->where('name', 'like', '%'.$request->search.'%')->get();

        // 'name' = Refers to the colum 'name' in the users table
        // 'like' = Specifies a partial match
        // '%'.$request->search.'%' = Represents the search term, enclosed in % signs, indicating that the term(word/character) can appear at the beginning, middle, or end of the colum 'name'

        return view('users.search')
                  ->with('users', $users) // Passes the retrieved user data to the view using the variable $users
                  ->with('search', $request->search); // Passes the search term to the view using the variable search
    }
}
