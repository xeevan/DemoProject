<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoutesTest extends TestCase
{
    public function test_redirect_user_to_login_page_if_not_authenticated()
    {
        $response = $this->get('/')->assertRedirect('/login');
    }

    public function test_authenticated_users_can_route_to_home_page()
    {
        $this->actingAs(factory(User::class)->create());
        $this->get('/image')->assertOk();
    }
}
