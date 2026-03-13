<?php

namespace App\Http\Controllers;

use App\Enums\CityCacheKey;
use App\Models\City;
use App\Models\Page;
use App\Models\Partner;
use Inertia\Inertia;
use Inertia\Response;

class PartnerController extends Controller
{
    /**
     * Display the partner page.
     */
    public function show(string $slug): Response
    {
        $partner = Partner::where('slug', $slug)->where('isActive', true)->firstOrFail();

        // Get active cities for footer
        $cities = \Cache::rememberForever(CityCacheKey::ACTIVE->value, function () {
            return City::active()->get();
        });

        return Inertia::render('partner', [
            'partner' => $partner,
            'Cities' => $cities,
            'seo' => Page::where('slug', 'partner')->first()?->seoMeta,
        ]);
    }
}
