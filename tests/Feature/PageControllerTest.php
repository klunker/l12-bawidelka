<?php

use App\Models\City;
use App\Models\Page;
use Illuminate\Support\Facades\Cache;
use Inertia\Testing\AssertableInertia as Assert;

beforeEach(function () {
    Cache::flush();
});

test('it shows active page with seo meta and cities', function () {
    City::factory()->count(3)->create(['active' => true]);
    City::factory()->create(['active' => false]);

    /** @var Page $page */
    $page = Page::factory()->create(['is_active' => true]);
    $page->seoMeta()->create([
        'title' => 'SEO Title',
        'description' => 'SEO Description',
        'keywords' => 'keyword1,keyword2',
    ]);

    $response = $this->get("/p/{$page->getAttribute('slug')}");

    $response->assertOk();

    $response->assertInertia(function (Assert $page) {
        $page
            ->component('static-page')
            ->has('page', function (Assert $pageData) {
                $pageData->hasAll([
                    'id', 'slug', 'title', 'content', 'is_active', 'created_at', 'updated_at', 'seo_meta',
                ]);
            })
            ->has('seo', function (Assert $seo) {
                $seo
                    ->hasAll([
                        'id', 'seoable_type', 'seoable_id', 'title', 'description', 'keywords', 'og_title',
                        'og_description', 'og_image', 'created_at', 'updated_at',
                    ])
                    ->where('title', 'SEO Title')
                    ->where('description', 'SEO Description')
                    ->where('keywords', 'keyword1,keyword2');
            })
            ->has('Cities', 3)
            ->where('Cities.0.active', true)
            ->where('Cities.1.active', true)
            ->where('Cities.2.active', true);
    });
});

test('it returns 404 for nonexistent slug', function () {
    $response = $this->get('/p/nonexistent-slug');

    $response->assertNotFound();
});

test('it returns 404 for inactive page', function () {
    $page = Page::factory()->create(['is_active' => false]);

    $response = $this->get("/p/{$page->getAttribute('slug')}");

    $response->assertNotFound();
});

test('cities are cached', function () {
    // Создаем активные города
    $activeCities = City::factory()->count(2)->create(['active' => true]);

    // Создаем страницу
    $page = Page::factory()->create(['is_active' => true]);

    // Первый запрос - должен заполнить кеш
    $response1 = $this->get("/p/{$page->getAttribute('slug')}");
    $response1->assertOk();

    // Проверяем, что кеш заполнен
    expect(Cache::get('cities-addresses:active:all'))->not->toBeNull();

    // Второй запрос - должен использовать кеш
    $response2 = $this->get("/p/{$page->getAttribute('slug')}");
    $response2->assertOk();

    // Проверяем, что в ответе есть города
    $response2->assertInertia(function (Assert $page) {
        $page->has('Cities', 2);
    });
});

test('page without seo meta still works', function () {
    // Создаем страницу без SEO мета данных
    $page = Page::factory()->create(['is_active' => true]);

    $response = $this->get("/p/{$page->getAttribute('slug')}");

    $response->assertOk();

    $response->assertInertia(function (Assert $page) {
        $page
            ->component('static-page')
            ->has('page')
            ->where('seo', null);
    });
});

test('empty cities list when no active cities', function () {
    // Создаем только неактивные города
    City::factory()->count(3)->create(['active' => false]);

    // Создаем страницу
    $page = Page::factory()->create(['is_active' => true]);

    $response = $this->get("/p/{$page->getAttribute('slug')}");

    $response->assertOk();

    $response->assertInertia(function (Assert $page) {
        $page
            ->component('static-page')
            ->has('Cities', 0);
    });
});

test('page content is rendered correctly', function () {
    $page = Page::factory()->create([
        'is_active' => true,
        'title' => 'Test Page Title',
        'content' => 'Test page content with <strong>HTML</strong>',
    ]);

    $response = $this->get("/p/{$page->getAttribute('slug')}");

    $response->assertOk();

    $response->assertInertia(function (Assert $page) {
        $page
            ->component('static-page')
            ->has('page', function (Assert $pageData) {
                $pageData
                    ->hasAll([
                        'id', 'slug', 'title', 'content', 'is_active', 'created_at', 'updated_at', 'seo_meta',
                    ])
                    ->where('title', 'Test Page Title')
                    ->where('content', '<p>Test page content with <strong>HTML</strong></p>')
                    ->where('is_active', true);
            });
    });
});
