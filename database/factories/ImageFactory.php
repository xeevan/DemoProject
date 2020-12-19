<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Image;
use Faker\Generator as Faker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

$factory->define(Image::class, function (Faker $faker) {

    $image = UploadedFile::fake()->image('image.jpg');
    $image_name = $image->getClientOriginalName();
    $image_extension = $image->getClientOriginalExtension();
    $image_full_name = $image_name.'.'.$image_extension;
    $upload_path = 'public/media/';
    $image->move($upload_path, $image_full_name);
    $image_path = $upload_path.$image_full_name;

    return [
        'img_url' => $image_path,
        'img_description' => $faker->paragraph,
        'user_id' => factory(\App\User::class)->create()->id
    ];
});


