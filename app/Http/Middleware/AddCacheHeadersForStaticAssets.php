<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AddCacheHeadersForStaticAssets
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Add cache headers for static assets served from storage
        if ($request->is('storage/*')) {
            $path = $request->path();
            $extension = pathinfo($path, PATHINFO_EXTENSION);

            // Cache images, fonts, CSS, and JS for 1 year
            if (in_array($extension, ['png', 'jpg', 'jpeg', 'gif', 'webp', 'svg', 'ico', 'woff', 'woff2', 'ttf', 'otf', 'css', 'js'])) {
                $response->headers->set('Cache-Control', 'public, max-age=31536000, immutable');
                $response->headers->set('Expires', gmdate('D, d M Y H:i:s \G\M\T', time() + 31536000));
            }
        }

        return $response;
    }
}
