<?php

namespace Tests\Unit;

use App\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class UserAccountTest extends TestCase
{
    use RefreshDatabase;
    public function test_new_user_created_after_signup()
    {
        $response = $this->post('/register', [
            'name' => 'Test Name',
            'email' => 'test@test.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);
        $response->assertRedirect($this->home_route());
        $this->assertCount(1, $users = User::all());
        $this->assertAuthenticatedAs($user = $users->first());
    }

    public function test_user_can_login_with_correct_credentials()
    {
        $user = factory(User::class)->create([
            'password' => Hash::make($password = 'password')
        ]);
        $response = $this->post('/login',[
            'email' => $user->email,
            'password' => $password
        ]);
        $response->assertRedirect($this->home_route());
        $this->assertAuthenticatedAs($user);
    }

    public function test_authenticated_user_can_logout()
    {
        $this->be(factory(User::class)->create());
        $response = $this->post('/logout');
        $response->assertRedirect('/login');
    }

    public function test_user_can_verify_with_verification_url()
    {
        $user = factory(User::class)->create([
            'email_verified_at' => null
        ]);
        $response = $this->actingAs($user)->get($this->verification_url_for_the_user($user));
        $response->assertRedirect($this->home_route());
        $this->assertNotNull($user->fresh()->email_verified_at);
    }

    public function test_user_verified_and_redirected_to_index_page()
    {
        $user = factory(User::class)->create([
            'email_verified_at' => now()
        ]);
        $response = $this->actingAs($user)->get($this->verification_notice_route());
        $response->assertRedirect($this->home_route());
    }

    public function test_user_can_resend_verification_email()
    {
        Notification::fake();
        $user = factory(User::class)->create([
            'email_verified_at' => null
        ]);
        $response = $this->actingAs($user)->from($this->verification_notice_route())->post($this->verification_resend_route());
        Notification::assertSentTo($user, VerifyEmail::class);
        $response->assertRedirect($this->verification_notice_route());
    }

    public function test_user_request_forgot_password_link()
    {
        Notification::fake();
        $user = factory(User::class)->create();
        $response = $this->post($this->password_email_route(), [
            'email' => $user->email
        ]);
        $this->assertNotNull($token = DB::table('password_resets')->first());
        Notification::assertSentTo($user, ResetPassword::class, function ($notification, $channels) use ($token) {
            return Hash::check($notification->token, $token->token) === true;
        });
    }

    public function test_user_can_reset_password()
    {
        Event::fake();
        $user = factory(User::class)->create();
        $response = $this->post($this->password_update_route(), [
            'token' => $this->get_valid_token($user),
            'email' => $user->email,
            'password' => 'new_password',
            'password_confirmation' => 'new_password'
        ]);
        $response->assertRedirect($this->home_route());
        $this->assertTrue(Hash::check('new_password', $user->fresh()->password));
        $this->assertAuthenticatedAs($user);
        Event::assertDispatched(PasswordReset::class, function($event) use ($user){
            return $event->user->id === $user->id;
        });
    }

    public function verification_url_for_the_user($user)
    {
        return URL::signedRoute('verification.verify', [
            'id' => $user->id,
            'hash' => sha1($user->getEmailForVerification())
        ]);
    }

    public function home_route()
    {
        return route('image.index');
    }

    public function verification_notice_route()
    {
        return route('verification.notice');
    }

    public function verification_resend_route()
    {
        return route('verification.resend');
    }

    public function password_email_route()
    {
        return route('password.email');
    }

    public function password_update_route()
    {
        return route('password.update');
    }

    public function get_valid_token($user)
    {
        return Password::broker()->createToken($user);
    }

}
