<?php

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageController;

Auth::routes(['verify' => true]);

Route::get('/', function(){
    if(Gate::denies('manage-users')){
        return redirect()->route('image.index');
    }
    return redirect()->route('admin.users.index');
})->middleware('auth');

Route::namespace('Admin')->prefix('admin')->name('admin.')->middleware('can:manage-users')->group(function(){
    Route::resource('/users', 'UsersController', ['except' => ['show', 'create', 'store', 'edit', 'update']]);
    Route::get('/users/posts/{id}', 'UsersController@getUserPosts')->name('users.posts');
});

Route::resource('image', 'ImageController');
