<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TenantIdentification
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Identify via Subdomain or Header (Advanced SaaS Pattern)
        $host = $request->getHost();
        $subdomain = explode('.', $host)[0];

        // Fallback for local dev or API header identifiers
        $tenantSlug = $request->header('X-Tenant-Slug') ?? $subdomain;

        if ($tenantSlug && $tenantSlug !== 'www' && $tenantSlug !== 'localhost') {
            $tenant = Tenant::where('slug', $tenantSlug)->where('is_active', true)->first();

            if (!$tenant) {
                return response()->json(['error' => 'Clinic domain not registered or inactive.'], 404);
            }

            // Bind the active tenant globally to the Laravel Service Container
            app()->instance(Tenant::class, $tenant);
        }
        return $next($request);
    }
}
