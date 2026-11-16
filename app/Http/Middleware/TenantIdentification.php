<?php

namespace App\Http\Middleware;

use App\Models\Tenant;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TenantIdentification
{
    public function handle(Request $request, Closure $next): Response
    {
        $host = $request->getHost();
        $subdomain = null;

        if (! filter_var($host, FILTER_VALIDATE_IP) && $host !== 'localhost') {
            $parts = explode('.', $host);

            if ((count($parts) === 2 && $parts[1] === 'localhost') || (count($parts) > 2 && $parts[0] !== 'www')) {
                $subdomain = $parts[0];
            }
        }

        $tenantSlug = $request->header('X-Tenant-Slug') ?? $subdomain;

        if ($tenantSlug) {
            $tenant = Tenant::where('slug', $tenantSlug)
                ->where('is_active', true)
                ->first();

            if (! $tenant) {
                abort(404, 'Clinic workspace not found or inactive.');
            }

            app()->instance(Tenant::class, $tenant);
        }

        return $next($request);
    }
}
