<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Menu;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_storefront_loads_and_filters_menus(): void
    {
        $category = Category::create([
            'name' => 'Hidangan Utama',
            'slug' => 'hidangan-utama',
            'is_active' => true,
        ]);

        Menu::create([
            'category_id' => $category->id,
            'name' => 'Nasi Goreng Wagyu Spesial',
            'slug' => 'nasi-goreng-wagyu',
            'price' => 68000,
            'is_available' => true,
        ]);

        $response = $this->get('/?search=Wagyu');

        $response->assertStatus(200);
        $response->assertSee('Nasi Goreng Wagyu Spesial');
    }

    public function test_multi_role_admin_dashboard_access(): void
    {
        $admin = User::create([
            'name' => 'Admin SomeFood',
            'email' => 'admin@somefood.com',
            'role' => 'admin',
            'password' => bcrypt('password'),
        ]);

        $response = $this->actingAs($admin)->get('/admin/dashboard');
        $response->assertStatus(200);
    }

    public function test_sanctum_jwt_api_login(): void
    {
        User::create([
            'name' => 'Admin SomeFood',
            'email' => 'admin@somefood.com',
            'role' => 'admin',
            'password' => bcrypt('password'),
        ]);

        $response = $this->postJson('/api/auth/login', [
            'email' => 'admin@somefood.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['success', 'access_token', 'user']);
    }
}
