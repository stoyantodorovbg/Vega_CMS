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

class AdminDeleteModelsFunctionalityTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function users_can_be_deleted_through_the_administration()
    {
        $this->authenticate(null, 'admins');

        $user = User::factory()->create();

        $this->delete('admin' . $this->localeUrlPrefix() . '/destroy', [
            'slug' => $user->getSlug(),
            'modelName' => 'user',
        ])->assertStatus(200);

        $this->assertDatabaseMissing('users', [
            'email' => $user->email
        ]);
    }

    /** @test */
    public function locales_can_be_deleted_through_the_administration()
    {
        $this->authenticate(null, 'admins');

        $locale = Locale::factory()->create();

        $this->delete('admin' . $this->localeUrlPrefix() . '/destroy', [
            'slug' => $locale->getSlug(),
            'modelName' => 'locale',
        ])->assertStatus(200);

        $this->assertDatabaseMissing('locales', [
            'language' => $locale->language
        ]);
    }

    /** @test */
    public function phrase_can_be_deleted_through_the_administration()
    {
        $this->authenticate(null, 'admins');

        $phrase = Phrase::factory()->create();

        $this->delete('admin' . $this->localeUrlPrefix() . '/destroy', [
            'slug' => $phrase->getSlug(),
            'modelName' => 'phrase',
        ])->assertStatus(200);

        $this->assertDatabaseMissing('phrases', [
            'system_name' => $phrase->system_name
        ]);
    }

    /** @test */
    public function group_can_be_deleted_through_the_administration()
    {
        $this->artisan('generate:group testgroupcreating --description=description');
        $group = Group::where('title', 'testgroupcreating')->first();

        $this->authenticate(null, 'admins');

        $this->withoutExceptionHandling();
        $this->delete('admin' . $this->localeUrlPrefix() . '/destroy', [
            'slug' => $group->getSlug(),
            'modelName' => 'group',
        ])->assertStatus(200);

        $this->assertDatabaseMissing('groups', [
            'title' => $group->title
        ]);
    }

    /** @test */
    public function route_can_be_deleted_through_the_administration()
    {
        $this->artisan('generate:route /testroute get TestController@testroute test.testroute');
        $route = Route::where('name', 'test.testroute')->first();

        $this->authenticate(null, 'admins');

        $this->delete('admin' . $this->localeUrlPrefix() . '/destroy', [
            'slug' => $route->getSlug(),
            'modelName' => 'route',
        ])->assertStatus(200);

        $this->assertDatabaseMissing('routes', [
            'name' => $route->name
        ]);
    }
}
