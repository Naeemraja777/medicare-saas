<?php

namespace App\Models;

use App\Traits\BelongsToTenant;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    use BelongsToTenant;

    public const string STATUS_SCHEDULED = 'scheduled';
    public const string STATUS_COMPLETED = 'completed';
    public const string STATUS_CANCELLED = 'cancelled';
    public const string STATUS_NO_SHOW = 'no_show';
    protected $fillable = [
        'tenant_id',
        'patient_id',
        'doctor_id',
        'appointment_date',
        'status',
        'symptoms_descriptions',
        'doctor_notes',
    ];
    protected $casts = ['appointment_date' => 'datetime'];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

    public function getStatusBadge(): string
    {
        return match($this->status){
        self::STATUS_SCHEDULED=>'bg-blue-100 text-blue-100',
        self::STATUS_COMPLETED=>'bg-emarald-100 text-emarald-800',
        self::STATUS_CANCELLED=>'bg-rose-100 text-rose-100',
        self::STATUS_NO_SHOW=>'bg-amber-100 text-amber-800',
            default=>'bg-slate-100 text-slate-100'

    };
}

}
