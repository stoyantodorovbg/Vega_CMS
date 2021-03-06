<?php

namespace Tests\Feature;

use Vegacms\Cms\Models\User;
use Vegacms\Cms\Models\Route;
use Vegacms\Cms\Models\Group;
use Vegacms\Cms\Models\Locale;
use Vegacms\Cms\Models\Phrase;
use Tests\VegaCmsTestCase as TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminPreviewPagesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_preview_page_can_be_visited_from_admins()
    {
        $user = User::factory()->create();
        $this->authenticate(null, 'admins');

        $this->get(route('admin-users.show', $user->getSlug()))
            ->assertStatus(200);
    }

    /** @test */
    public function user_data_can_be_viewed_on_user_show_page()
    {
        $this->authenticate(null, 'admins');

        $user = User::factory()->create([
                'name' => 'Test User'
            ]
        );

        $this->get(route('admin-users.show', $user->id))
            ->assertSee('Test User');
    }

    /** @test */
    public function group_preview_page_can_be_visited_from_admins()
    {
        $group = Group::factory()->create();
        $this->authenticate(null, 'admins');

        $this->get(route('admin-groups.show', $group->getSlug()))
            ->assertStatus(200);
    }

    /** @test */
    public function group_data_can_be_viewed_on_group_show_page()
    {
        $this->authenticate(null, 'admins');

        $group = Group::factory()->create([
                'title' => 'Test Group'
            ]
        );

        $this->get(route('admin-groups.show', $group->id))
            ->assertSee('Test Group');
    }

    /** @test */
    public function phrase_preview_page_can_be_visited_from_admins()
    {
        $phrase = Phrase::factory()->create();
        $this->authenticate(null, 'admins');

        $this->get(route('admin-phrases.show', $phrase->getSlug()))
            ->assertStatus(200);
    }

    /** @test */
    public function phraser_data_can_be_viewed_on_phrase_show_page()
    {
        $this->authenticate(null, 'admins');

        $phrase = Phrase::factory()->create([
                'system_name' => 'test_system_name'
            ]
        );

        $this->get(route('admin-phrases.show', $phrase->id))
            ->assertSee('test_system_name');
    }

    /** @test */
    public function route_preview_page_can_be_visited_from_admins()
    {
        $route = Route::factory()->create();
        $this->authenticate(null, 'admins');

        $this->get(route('admin-routes.show', $route->getSlug()))
            ->assertStatus(200);
    }

    /** @test */
    public function route_data_can_be_viewed_on_route_show_page()
    {
        $this->authenticate(null, 'admins');

        $route = Route::factory()->create([
                'url' => '/test'
            ]
        );

        $this->get(route('admin-routes.show', $route->id))
            ->assertSee('/test');
    }

    /** @test */
    public function locale_preview_page_can_be_visited_from_admins()
    {
        $locale = Locale::factory()->create();
        $this->authenticate(null, 'admins');

        $this->get(route('admin-locales.show', $locale->getSlug()))
            ->assertStatus(200);
    }

    /** @test */
    public function locale_data_can_be_viewed_on_locale_show_page()
    {
        $this->authenticate(null, 'admins');

        $locale = Locale::factory()->create([
                'code' => 'fr'
            ]
        );

        $this->get(route('admin-locales.show', $locale->id))
            ->assertSee('fr');
    }
}
