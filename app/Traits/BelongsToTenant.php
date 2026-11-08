<?php
namespace App\Traits;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;


trait BelongsToTenant{
protected static function bootBelongsToTenant(){
    //Automatically scope all queries by the authenticated users tenant
    static::addGlobalScope('tenant',function(Builder $builder){
        if(auth()->check()){
            $builder->where('tenant_id',auth()->user()->tenant_id);
        }
    });
    //2 Automatically assign the tenant id when create new records
  static::creating(function(Model $model){
      if(auth()->check() && !$model->tenant_id){
          $model->tenant_id=auth()->user()->tenant_id;

      }
  });
}
public function tenant(){
    return $this->belongsTo(Tenant::class);
}
}


