<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ImageController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('verified')->only(['index', 'store', 'create']);

    }

    public function index(){
        $images = DB::table('images')->where('user_id', Auth::user()->id)->get();
        return view('users.image.userDashboard', compact('images'));
    }

    public function create(){
        return view('users.image.uploadImage');
    }

    public function store(Request $request){
        $validated_data = $request->validate([
            'img_url'=> ['required'],
            'img_description' => ['required']
        ]);

        $validated_data['user_id'] = $request->user()->id;
        $validated_data['img_description'] = $request->img_description;
        $image = $request->file('img_url');

        if($image){
            $validated_data['img_url'] = $this->uploadImage($image);
        }

        DB::table('images')->insert($validated_data);
        return redirect()->route('image.create')->with('success', 'Image added successfully!');
    }

    public function show($id){
        $image = $this->getImageData($id)->first();
        if(Gate::denies('view-edit-others-post', $image)){
            abort(403);
        }
        return view('users.image.imageDetails', compact('image'));
    }

    public function edit($id){
        $image = $this->getImageData($id)->first();
        if(Gate::denies('view-edit-others-post', $image)){
            abort(403);
        }
        return view('users.image.editDetails', compact('image'));
    }

    public function update(Request $request, $id){
        $image_data = $this->getImageData($id);
        if(Gate::denies('view-edit-others-post', $image_data->first())){
            abort(403);
        }
        $data = array();
        $data['img_description'] = $request->img_description;
        $image = $request->file('img_url');
        $image_old_link = $request->old_image;

        if($image){
            unlink($image_old_link);
            $data['img_url'] = $this->uploadImage($image);
        }

        $image_data->update($data);
        return redirect()->route('image.show', $id)->with('success', 'Image Details updated successfully.');
    }

    public function destroy($id){
        $image_data = $this->getImageData($id);
        $image = $image_data->first();
        if(Gate::denies('view-edit-others-post', $image)){
            abort(403);
        }
        unlink($image->img_url);
        $image_data->delete();
        return redirect()->route('image.index')->with('success', 'Image deleted successfully!');
    }

    private function getImageData($id){
        return $image = DB::table('images')->where('id', $id);
    }

    private function uploadImage($image){
        $image_name = $image->getClientOriginalName();
        $image_extension = $image->getClientOriginalExtension();
        $image_full_name = $image_name.'.'.$image_extension;
        $upload_path = 'public/media/';
        $image->move($upload_path, $image_full_name);
        return $upload_path.$image_full_name;
    }
}
