<?php

namespace App\Http\Controllers;

use App\Enums\ActivityCacheKey;
use App\Enums\CityCacheKey;
use App\Enums\ServiceCacheKey;
use App\Helpers\RichContentRendererHelper;
use App\Models\Activity;
use App\Models\City;
use App\Models\Service;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ServiceViewController extends Controller
{
    public function __invoke(string $serviceSlug): Response
    {

        $service = Cache::rememberForever(ServiceCacheKey::SINGLE->value.$serviceSlug, function () use ($serviceSlug) {
            return Service::with(['cities', 'seoMeta'])
                ->where('slug', $serviceSlug)
                ->first();
        });

        if (! isset($service)) {
            throw new NotFoundHttpException;
        }

        $service->description = RichContentRendererHelper::render($service->description);
        $service->description_additional = RichContentRendererHelper::render($service->description_additional);

        return Inertia::render('service', [
            'Cities' => Cache::rememberForever(CityCacheKey::ACTIVE->value, function () {
                return City::active()->get();
            }),
            'Service' => $service,
            'seo' => function () use ($serviceSlug) {
                $service = Service::where('slug', $serviceSlug)->first();

                return $service?->seoMeta;
            },
            'Activities' => Cache::rememberForever(ActivityCacheKey::ACTIVE->value, function () {
                return Activity::with('cities')
                    ->where('isActive', true)
                    ->orderBy('order')
                    ->get();
            }),
        ]);
    }
}
