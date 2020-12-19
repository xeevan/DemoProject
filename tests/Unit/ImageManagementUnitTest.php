<?php

namespace Tests\Unit;

use App\Image;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ImageManagementTest extends TestCase
{
    use RefreshDatabase;
    public function test_image_details_uploaded()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)->post( $this->image_post_route(), [
            'img_description' => "This is a product",
            'img_url' => UploadedFile::fake()->image('image.jpg'),
            'user_id' => $user->id,
        ]);
        $response->assertRedirect('/image/create');
        $this->assertCount(1, DB::table('images')->get());
    }

    public function test_image_details_can_be_edited()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $data = [
            'img_description' => "This is a product",
            'img_url' => UploadedFile::fake()->image('initial_image.jpg'),
            'user_id' => $user->id,
        ];
        $this->actingAs($user)->post( $this->image_post_route(), $data);
        $image = Image::all()->first();

        $new_data = [
            'img_description' => "Updated Description",
            'img_url' => UploadedFile::fake()->image('updated_image.jpg'),
            'user_id' => $user->id,
            'old_image' => 'public/media/initial_image.jpg.jpg'
        ];
        $this->actingAs($user)->put($this->image_update_route($image), $new_data);
        $new_image = Image::all()->first();
        $new_image_path = '/media/updated_image.jpg';
        $this->assertEquals($new_data['img_description'], $new_image->img_description);
        //$this->assertEquals($new_image_path, $new_image->img_url);
    }

    public function test_image_details_deleted()
    {
        $this->withoutExceptionHandling();
        $image = factory(Image::class)->create();
        $this->assertCount(1, Image::all());
        $user = User::find($image->user_id);
        $response = $this->actingAs($user)->delete($this->image_delete_route($image));
        $this->assertCount(0, Image::all());
    }

    public function image_post_route()
    {
        return route('image.store');
    }

    public function image_delete_route($image)
    {
        return route('image.destroy', $image);
    }

    public function image_update_route($image)
    {
        return route('image.update', $image);
    }

}
