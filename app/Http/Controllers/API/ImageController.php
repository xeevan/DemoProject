<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ImageResource;
use App\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $images = Image::where('user_id', auth()->user()->id)->get();
        return response([
            'images' => ImageResource::collection($images),
            'message' => 'Retrieved Successfully'
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data,[
            'img_url'=> ['required'],
            'img_description' => ['required']
        ]);

        if($validator->fails())
        {
            return response([
                'error' => $validator->errors(),
                'message' => 'Validation Errors'
            ]);
        }

        $data['user_id'] = auth()->user()->id;
        $data['img_description'] = $request->img_description;
        $image = $request->file('img_url');

        if($image){
            $data['img_url'] = $this->uploadImage($image);
        }

        $image = Image::create($data);
        return response([
            'image' => new ImageResource($image),
            'message' => 'Image added successfully'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function show(Image $image)
    {
        if(Gate::denies('view-edit-others-post', $image)){
            return response([
                'message' => 'Not authorized.'
            ]);
        }
        return response([
            'image' => new ImageResource($image),
            'message' => 'Image retrieved successfully'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Image $image)
    {
        if(Gate::denies('view-edit-others-post', $image)){
            return response([
                'message' => 'Not authorized.'
            ]);
        }
        $data = $request->all();
        $image_old_link = $image->img_url;
        $validator = Validator::make($data,[
            'img_url'=> ['required'],
            'img_description' => ['required']
        ]);

        if($validator->fails())
        {
            return response([
                'error' => $validator->errors(),
                'message' => 'Validation Errors'
            ]);
        }
        $uploaded_image = $request->file('img_url');

        if($uploaded_image){
            unlink($image_old_link);
            $data['img_url'] = $this->uploadImage($uploaded_image);
        }

        $image->update($data);

        return response([
            'image' => new ImageResource($image),
            'message' => 'Image updated successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function destroy(Image $image)
    {
        if(Gate::denies('view-edit-others-post', $image)){
            return response([
                'message' => 'Not authorized.'
            ]);
        }
        $image->delete();
        return response([
            'message' => 'Image Deleted Successfully.'
        ]);
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
