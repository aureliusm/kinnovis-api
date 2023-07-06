<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpFoundation\Response;

class Localization
{
    public function __construct(
        private Application $app,
    ) {
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->hasHeader('Accept-Language')) {

            /** @var string $locale */
            $locale = $request->header('Accept-Language');

            /** @var array<string, string> $locales */
            $locales = Config::get('app.locales');

            // Make sure requested locale exists in array of allowed locales
            if (array_key_exists($locale, $locales)) {
                $this->app->setLocale($locale);
            }
        }

        return $next($request);
    }
}
