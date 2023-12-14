<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    private $post;

    private $category;

    public function __construct(Post $post, Category $category)
    {
        $this->post = $post;
        $this->category = $category;
    }

    public function create(){
        $all_categories = $this->category->all();

        return view('users.posts.create')
                         ->with('all_categories', $all_categories);
    }

    public function store(Request $request){
        $request->validate([
            'category' =>'required|array|between:1,3',
            'description' =>'required|min:1|max:1000',
            'image' =>'required|mimes:jpeg,jpg,gif,png|max:1048'
        ]);

        $this->post->user_id = Auth::user()->id; //user_id is a FK(foreign key), id is a PK from our user table
        $this->post->image = 'data:/image/'.$request->image->extension().';base64,'.base64_encode(file_get_contents($request->image));
        // Set the image path of the post to the base64 encoded image data
        $this->post->description = $request->description;

        $this->post->save();

        //Save the categories to the category_post_table
        //category = ['1,2,3']
        foreach ($request->category as $category_id){
            // Create an associate array with the category ID as the KEY
            // ['category_id' => Travel] = ['category_id' => 1]
            $category_post[] = ['category_id' => $category_id];
        }

        // Create a new CategoryPost record for each category ID
        $this->post->categoryPost()->createMany($category_post);
        // createMany was used to insert multiple records
        //It will automaticall create 'post_id' -> 1

        return redirect()->route('index');

        // GIVEN
        // $this->post->id = 1;
        // $request->category = [1,4]; Category : Travel, Music

        // After the foreach loop
            // $category_post = [
            // ['category_id' => 1],
            // ['category_id' => 4]
            // ];
        // After the $this->post->createPost()
            // $category_post = [
            // ['category_id' => 1, 'post_id' => 1]
            // ['category_id' => 4, 'post_id' => 2]
            // ];
    }

    public function show($id){
        $post =  $this->post->findOrFail($id);

        return view('users.posts.show')->with('post' , $post);
    }

    public function edit($id){
        $post =  $this->post->findOrFail($id);

        //Check if the Auth User is not the owner of the post redirect to homepage
        if(Auth::user()->id != $post->user->id){
            return redirect()->route('index');
        }

        $all_categories = $this->category->all();

        // Get all the category ID's of this Post, Save in an array
        $selected_categories = []; //$selected_categories = [3,5]
        foreach ($post->categoryPost as $category_post){
            $selected_categories[] = $category_post->category_id;
        }

        return view('users.posts.edit')
                   ->with('post', $post)
                   ->with('all_categories', $all_categories)
                   ->with('selected_categories', $selected_categories);
    }

    public function update(Request $request, $id){
        // 1. Validation
        $request->validate([
            'category' =>'required|array|between:1,3',
            'description' =>'required|min:1|max:1000',
            'image' =>'mimes:jpeg,jpg,gif,png|max:1048'
        ]);

        // 2. Update the post
        $post = $this->post->findOrFail($id);
        $post->description = $request->description;

        // 2. If there is a new image
        if($request->image){
            $post->image = 'data:/image/'.$request->image->extension().';base64,'.base64_encode(file_get_contents($request->image));
        }

        $post->save();

        // 3. Delete all records from category_post related to this post
        $post->categoryPost()->delete();
        // We use the relationship Post::categoryPost() to select the records related to a post
        // Equivalent : DELETE FROM category_post WHERE post_id = $id

        // 4. Save the new categories to category_post table
        foreach($request->category as $category_id){
            $category_post[] = ['category_id' => $category_id];
        }
        $post->categoryPost()->createMany($category_post);

        // 5. Redirect to show post page
        return redirect()->route('post.show', $id);

    }

    public function destroy($id){

        $post = $this->post->findOrFail($id);

        $post->forceDelete();
        // Permanently delete the retrieved post

        return back();
       }
}
