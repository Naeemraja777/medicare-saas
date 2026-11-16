<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant;

class Doctor extends Model
{
use BelongsToTenant;
protected $fillable=[
    'tenant_id',
    'user_id',
    'specialization',
    'license_number',
    'phone',
    'status',
];
public function user(){
    return $this->belongsTo(User::class);

}

}
