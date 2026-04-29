<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TestController extends Controller
{
    public function __invoke(Request $request): Response
    {
        return Inertia::render('test', [
            'clientInfo' => [
                'ip' => $request->ip(),
                'userAgent' => $request->userAgent(),
                'acceptLanguage' => $request->header('accept-language'),
                'accept' => $request->header('accept'),
            ],
        ]);
    }
}
