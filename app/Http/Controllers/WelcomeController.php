<?php

namespace App\Http\Controllers;

use App\Enums\AboutContentCacheKey;
use App\Enums\ActivityCacheKey;
use App\Enums\CityCacheKey;
use App\Enums\FaqCacheKey;
use App\Enums\GoogleReviewsCacheKey;
use App\Enums\PartnerCacheKey;
use App\Enums\ReasonCacheKey;
use App\Enums\ServiceCacheKey;
use App\Facades\GoogleReviews;
use App\Models\AboutContent;
use App\Models\Activity;
use App\Models\City;
use App\Models\Faq;
use App\Models\Partner;
use App\Models\Reason;
use App\Models\Service;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;
use Inertia\Response;

class WelcomeController extends Controller
{
    public function __invoke(): Response
    {
        return Inertia::render('welcome', [
            'Cities' => Cache::rememberForever(CityCacheKey::ACTIVE->value, function () {
                return City::active()->get();
            }),
            'Reasons' => Cache::rememberForever(ReasonCacheKey::ACTIVE->value, function () {
                return Reason::active()->get();
            }),
            'Faqs' => Cache::rememberForever(FaqCacheKey::ACTIVE->value, function () {
                return Faq::active()->get();
            }),
            'Partners' => Cache::rememberForever(PartnerCacheKey::ACTIVE->value, function () {
                return Partner::active()->orderBy('order')->get();
            }),
            'Activities' => Cache::rememberForever(ActivityCacheKey::ACTIVE->value, function () {
                return Activity::with('cities')->active()->orderBy('order')->get();
            }),
            'Services' => Cache::rememberForever(ServiceCacheKey::ACTIVE->value, function () {
                return Service::with('cities')->active()->orderBy('services.sort_order')->get();
            }),
            'AboutContent' => Cache::rememberForever(AboutContentCacheKey::ACTIVE->value, function () {
                return AboutContent::active()->first();
            }),
            'GoogleReviews' => Cache::rememberForever(GoogleReviewsCacheKey::ACTIVE->value, function () {
                return GoogleReviews::getActiveReviews();
            }),
            'seo' => \App\Models\Page::where('slug', 'home')->first()?->seoMeta,
        ]);
    }
}
