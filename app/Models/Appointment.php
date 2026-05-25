<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'client_name', 'client_phone', 'client_email',
        'service_id', 'duration_minutes', 'staff_id', 'equipment_id',
        'appointment_date', 'appointment_time', 'status', 'notes', 'ghl_contact_id',
        'whatsapp_reminder_sent_at',
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'whatsapp_reminder_sent_at' => 'datetime',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }
}
