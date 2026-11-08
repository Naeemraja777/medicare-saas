<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IdentifyTenant
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $host=$request->getHost();
        $parts=explode('.',$host);
        //Extract subdomain if not  on bare localhost or main domain
        $subdomain=(count($parts)>2 && $parts[0]!=='www')?$parts[0]:null;
        //Allow header override for local testing and rest api clients
        $tenantSlug=$request->header('X-Tenant-Slug') ?? $subdomain;
        if($tenantSlug){
            $tenant=Tenant::where('slug',$tenantSlug)
                ->where('is_active',true)
                ->first();
            if(!$tenant){
                abort(404,'clinic workspace not found');
            }
            //Bind the active tenant globally to the Laravel Service container
            app()->instance(Tenant::class,$tenant);
        }



        return $next($request);
    }
}
