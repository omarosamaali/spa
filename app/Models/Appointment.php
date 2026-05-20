<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'client_name', 'client_phone', 'client_email',
        'service_id', 'staff_id', 'appointment_date',
        'appointment_time', 'status', 'notes', 'ghl_contact_id',
    ];

    protected $casts = [
        'appointment_date' => 'date',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }
}
