<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_users_are_redirected_to_login_from_admin_routes(): void
    {
        $response = $this->get('/admin');

        $response->assertRedirect('/login');
    }

    public function test_admin_users_can_access_admin_dashboard(): void
    {
        $admin = User::factory()->create([
            'email' => 'admin@gcmagazine.edu',
            'password' => bcrypt('password'),
            'is_admin' => true,
            'is_active' => true,
        ]);

        $this->actingAs($admin);

        $response = $this->get('/admin');

        $response->assertOk();
    }

    public function test_non_admin_users_are_redirected_from_admin_routes(): void
    {
        $user = User::factory()->create([
            'email' => 'editor@gcmagazine.edu',
            'password' => bcrypt('password'),
            'is_admin' => false,
            'is_active' => true,
        ]);

        $this->actingAs($user);

        $response = $this->get('/admin');

        $response->assertRedirect('/login');
    }
}
