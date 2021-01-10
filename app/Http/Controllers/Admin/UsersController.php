<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Role;
use App\User;
use App\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class UsersController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $users = User::paginate(10);
        return view('admin.users.index')->with('users', $users);
    }

    public function destroy(User $user){
        $user->roles()->detach();
        $user->delete();
        return redirect()->route('admin.users.index');
    }

    public function getUserPosts($id){
        $images = Image::where('user_id', $id)->paginate(6);
        return view('users.image.userDashboard')->with('images', $images);
    }

    public function getPosts(Request $request){ 
        $request->session()->put('by_user', false);
        if($request->input('page')){
            if($request->session()->get('is_from_posts_page')){
                $sort_order = $request->session()->get('sortOrder', 'desc');
                $sort_order = $sort_order == 'desc' ? 'asc': 'desc';
                $images = Image::orderBy('created_at', $sort_order)->paginate(5);
                $request->session()->put('is_from_posts_page', false);
            }
            else{
                $sort_order = $request->session()->get('sortOrder', 'desc');
                $sort_order = $sort_order == 'desc' ? 'asc': 'desc';
                $images = Image::orderBy('created_at', $sort_order)->paginate(5);
            }
        } 
        else{
            $sort_order = $request->session()->get('sortOrder', 'desc');
            $images = Image::orderBy('created_at', $sort_order)->paginate(5);
            $sort_order = $sort_order == 'desc' ? 'asc': 'desc';
            $request->session()->put('sortOrder', $sort_order);
            $request->session()->put('is_from_posts_page', true);
        }
        
        return view('admin.users.all_posts')->with(['images' => $images, 'sort_by_date' => true]);
    }

    public function getPostsOrderByUser(Request $request){
        /*$images = Image::with('user')->get()->sortBy(function($image) { 
                    return $image->user->name;
            });*/
        $images = DB::table('images')
                    ->join('users', 'images.user_id', '=', 'users.id')
                    ->select('images.*', 'users.name')
                    ->orderBy('name')
                    ->paginate(5);
        $request->session()->put('by_user', true);
        
        return view('admin.users.all_posts')->with(['images' => $images, 'sort_by_date' => false]);
    }

    public function getDashboardData(){
        $total_users = Role::where('name', 'user')->first()->users()->get()->count();
        $last_active_user = User::latest('last_logged_in_at')->first();
        if($last_active_user->last_logged_in_at == null){
            $last_active_user = null;
        }

        $start_of_today = now()->startOfDay();
        $start_of_previous_day = now()->startOfDay()->subDays(1);
        $number_of_image_uploads_for_the_last_day = Image::whereBetween('created_at', [$start_of_previous_day, $start_of_today])->get()->count();

        $start_of_week = now()->startOfWeek();
        $start_of_previous_week = now()->startOfWeek()->subWeek(1);
        $number_of_image_uploads_for_the_last_week = Image::whereBetween('created_at', [$start_of_previous_week, $start_of_week])->get()->count();


        $start_of_month = now()->startOfMonth();
        $start_of_previous_month = now()->startOfMonth()->subMonth(1);
        $number_of_image_uploads_for_the_last_month = Image::whereBetween('created_at', [ $start_of_previous_month, $start_of_month])->get()->count();

        $start_of_month = now()->startOfMonth();
        $start_of_previous_three_month = now()->startOfMonth()->subMonth(3);
        $number_of_image_uploads_for_the_last_quarter = Image::whereBetween('created_at', [ $start_of_previous_three_month, $start_of_month])->get()->count();

        $start_of_year = now()->startOfYear();
        $start_of_previous_year = now()->startOfYear()->subYear(1);
        $number_of_image_uploads_for_the_last_year = Image::whereBetween('created_at', [ $start_of_year, $start_of_previous_year])->get()->count();

        $total_number_of_image_uploads = Image::all()->count(); 

        $data = array(
            'total_users' => $total_users,
            'last_active_user' => $last_active_user,
            'number_of_image_uploads_for_the_last_day' => $number_of_image_uploads_for_the_last_day,
            'number_of_image_uploads_for_the_last_week' => $number_of_image_uploads_for_the_last_week,
            'number_of_image_uploads_for_the_last_month' => $number_of_image_uploads_for_the_last_month,
            'number_of_image_uploads_for_the_last_quarter' => $number_of_image_uploads_for_the_last_quarter,
            'number_of_image_uploads_for_the_last_year' => $number_of_image_uploads_for_the_last_year,
            'total_number_of_image_uploads' => $total_number_of_image_uploads
        );
        return view('admin.users.admin_dashboard')->with($data);
    }
}
