<?php
namespace App\Traits;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;


trait BelongsToTenant{
protected static function bootBelongsToTenant():void{
    //Automatically scope all queries by the authenticated users tenant
    static::addGlobalScope('tenant',function(Builder $builder) {
        $tenantId = static::resolveTenantId();
        if ($tenantId) {
            $builder->where('tenant_id', $tenantId);
        }
    });


    //2 Automatically assign the tenant id when create new records
  static::creating(function(Model $model){
      if(!$model->tenant_id){
          $model->tenant_id=static::resolveTenantId();

      }
  });
}
    protected static function resolveTenantId():?int
    {
        if (app()->bound(Tenant::class)) {
            return app(Tenant::class)->id;

        }

        return auth()->check() ? auth()->user()->tenant_id : null;
    }
public function tenant()
{
    return $this->belongsTo(Tenant::class);
}
}


