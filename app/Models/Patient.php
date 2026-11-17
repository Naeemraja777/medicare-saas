<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Patient extends Model
{
    use BelongsToTenant;
    protected $guarded=[];
    protected $fillable=[
        'tenant_id',
        'patient_number',
        'name',
        'date_of_birth',
        'gender',
        'phone',
        'email',
        'medical_history',
    ];
    protected $casts=['date_of_birth'=>'date'];
    public static function booted():void
    {
        static::creating(function(Patient $patient){
            if(empty($patient->patient_number)){
                $patient->patient_number='PAT-'.date('Y').'-'.strtoupper(Str::random(6));
            }

        });
    }
    public function appointments(){
        return $this->hasMany(Appointment::class);
    }


}
