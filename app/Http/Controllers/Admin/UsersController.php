<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index()
    {
        $users = User::all();
        return view('admin.users.index')->with('users', $users);
    }

    public function destroy(User $user)
    {
        $user->roles()->detach();
        $user->delete();
        return redirect()->route('admin.users.index');
    }

    public function getUserPosts($id){
        $images = DB::table('images')->where('user_id', $id)->get();
        return view('users.image.userDashboard')->with('images', $images);
    }
}
