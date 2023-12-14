<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    private $user;

    public function __construct(User $user) {
        $this->user = $user;
    }

    public function index(){
        $all_users = $this->user->withTrashed()->latest()->paginate(3);
        //withTrashed() includes the soft deleted records in a query result
        //Pagination - is the process of dividing a large set of ta into pages
        //paginate() -> 3 it will display specific resulton each page
        //Pages depending on the data that we have inside on the database
        // For example. 10 users / 3
        // First Page 3 users to be displayed
        // Second Page 3 users to be displayed
        // Third Page 3 users to be displayed
        // Fourth Page 1 user to be displayed
        
        return view('admin.users.index')->with('all_users', $all_users);
    }

    public function deactivate($id){
        $this->user->destroy($id);

        return redirect()->back();
    }

    public function activate($id){
        $this->user->onlyTrashed()->findOrFail($id)->restore();
         //onlyTrashed was use to retrieve soft deleted  records exclusively
         //restore() was use to 'un-delete' a softdeleted data ->this action will set the 'deleted_at' colum to NULL

         return redirect()->back();
        
        }

    }
