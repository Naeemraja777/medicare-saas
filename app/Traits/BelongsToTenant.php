<?php

namespace App\Traits;

use App\Models\Tenant;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

trait BelongsToTenant
{
    protected static function bootBelongsToTenant(): void
    {
        static::addGlobalScope('tenant', function (Builder $builder) {
            $tenantId = static::resolveTenantId();
            if ($tenantId) {
                $builder->where($builder->getModel()->getTable().'.tenant_id', $tenantId);
            }
        });

        static::creating(function (Model $model) {
            if (! $model->tenant_id) {
                $model->tenant_id = static::resolveTenantId();
            }
        });
    }

    protected static function resolveTenantId(): ?int
    {
        if (app()->bound(Tenant::class)) {
            return app(Tenant::class)->id;
        }

        // Use hasUser() instead of check() to prevent infinite recursion on User model queries
        return auth()->hasUser() ? auth()->user()->tenant_id : null;
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}

