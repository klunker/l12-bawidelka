<?php

namespace App\Jobs;

use App\Models\Service;
use App\Observers\ServiceObserver;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Format;
use Intervention\Image\ImageManager;

class OptimizeServiceImages implements ShouldQueue
{
    use Queueable;

    /**
     * The service instance.
     */
    public Service $service;

    /**
     * Create a new job instance.
     */
    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $manager = ImageManager::usingDriver(Driver::class);

        // Optimize main image
        if ($this->service->image) {
            $this->optimizeImage($manager, $this->service->image, 'services', 640, 520);
        }

        // Optimize header image
        if ($this->service->headerImage) {
            $this->optimizeImage($manager, $this->service->headerImage, 'services/headers', 1920, 600);
        }

        // Trigger ServiceObserver updated method to refresh cache
        app(ServiceObserver::class)->updated($this->service);
    }

    /**
     * Optimize a single image.
     */
    protected function optimizeImage(ImageManager $manager, string $imagePath, string $directory, int $maxWidth, int $maxHeight): void
    {
        $disk = Storage::disk('public');

        if (! $disk->exists($imagePath)) {
            return;
        }

        $imageContent = $disk->get($imagePath);
        $image = $manager->decodeBinary($imageContent);

        // Resize if needed
        $image->scale(width: $maxWidth, height: $maxHeight);

        // Convert to WebP with 80% quality for better optimization
        $optimizedImage = $image->encodeUsingFormat(Format::WEBP, quality: 80);

        // Generate new filename
        $pathInfo = pathinfo($imagePath);
        $newFilename = $pathInfo['filename'].'_optimized.webp';
        $newPath = $directory.'/'.$newFilename;

        // Save optimized image
        $disk->put($newPath, $optimizedImage);

        // Update the service model with the new image path
        if ($directory === 'services') {
            $this->service->image = $newPath;
        } else {
            $this->service->headerImage = $newPath;
        }

        $this->service->saveQuietly();
    }
}
