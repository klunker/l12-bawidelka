<?php

namespace App\Http\Controllers;

use App\Enums\CityCacheKey;
use App\Helpers\RichContentRendererHelper;
use App\Models\City;
use App\Models\Page;
use App\Models\Partner;
use Illuminate\Support\Facades\Cache;
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
        $partner->description = RichContentRendererHelper::render($partner->description);

        // Get active cities for footer
        $cities = Cache::rememberForever(CityCacheKey::ACTIVE->value, function () {
            return City::active()->get();
        });

        return Inertia::render('partner', [
            'partner' => $partner,
            'Cities' => $cities,
            'seo' => Page::where('slug', 'partner')->first()?->seoMeta,
        ]);
    }
}
