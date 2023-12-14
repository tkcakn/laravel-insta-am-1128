<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    private $comment;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    public function store(Request $request, $post_id){
        // Validate the comment input based on the $post_id parameter
        $request->validate([
            'comment_body'.$post_id => 'required|min:1|max:150'
        ],
    [
        'comment_body'.$post_id.'.required' => 'You cannot submit an empty comment.',
        'comment_body'.$post_id.'.min' => 'The minimum value of the comment must be 1 character.',
        'comment_body'.$post_id.'.max' => 'The comment must not have more than 150 characters.'
    ]
);

        //Set the 'body' attribute of the comment from the request input
        $this->comment->body = $request->input('comment_body'.$post_id);

        // Set the 'user_id' of the comment to the Autenticated User's ID
        $this->comment->user_id = Auth::user()->id;

        // Set the 'post_id' of the comment to the value of parameter $post_id
        $this->comment->post_id = $post_id;

        $this->comment->save();

        return redirect()->back(); // Redirect back to the previous page

    }

    public function destroy($id){

        $this->comment->destroy($id);
    
        return back();
       }
}
