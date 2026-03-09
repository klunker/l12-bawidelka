<?php

namespace App\Http\Controllers;

use App\Enums\CityCacheKey;
use App\Models\City;
use App\Models\Partner;
use Inertia\Inertia;

class PartnerController extends Controller
{
    /**
     * Display the partner page.
     */
    public function show(string $slug): \Inertia\Response
    {
        $partner = Partner::where('slug', $slug)->where('isActive', true)->firstOrFail();

        // Get active cities for footer
        $cities = \Cache::rememberForever(CityCacheKey::ACTIVE->value, function () {
            return City::active()->get();
        });

        return Inertia::render('partner', [
            'partner' => $partner,
            'Cities' => $cities,
            'seo' => \App\Models\Page::where('slug', 'partner')->first()?->seoMeta,
        ]);
    }
}
