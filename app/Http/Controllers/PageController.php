<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Inertia\Inertia;
use Inertia\Response;

class PageController extends Controller
{
    public function show(string $slug): Response
    {
        $page = Page::where('slug', $slug)
            ->where('is_active', true)
            ->with('seoMeta')
            ->firstOrFail();

        return Inertia::render('static-page', [
            'page' => $page,
            'seo' => $page->seoMeta,
            'Cities' => \Illuminate\Support\Facades\Cache::rememberForever('cities-addresses:active:all', function () {
                return \App\Models\City::active()->get();
            }),
        ]);
    }
}
