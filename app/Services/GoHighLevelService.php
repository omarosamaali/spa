<?php

namespace App\Services;

use App\Models\Appointment;
use Illuminate\Support\Facades\Http;

class GoHighLevelService
{
    private string $apiKey;
    private string $locationId;
    private string $baseUrl = 'https://rest.gohighlevel.com/v1';

    public function __construct()
    {
        $this->apiKey = config('services.ghl.api_key', '');
        $this->locationId = config('services.ghl.location_id', '');
    }

    public function createContact(Appointment $appointment): ?string
    {
        if (empty($this->apiKey)) {
            return null;
        }

        $response = Http::withHeaders([
            'Authorization' => "Bearer {$this->apiKey}",
            'Content-Type'  => 'application/json',
        ])->post("{$this->baseUrl}/contacts/", [
            'locationId' => $this->locationId,
            'firstName'  => $appointment->client_name,
            'phone'      => $appointment->client_phone,
            'email'      => $appointment->client_email,
            'tags'       => ['spa-booking', $appointment->service->name ?? 'service'],
        ]);

        if ($response->successful()) {
            return $response->json('contact.id');
        }

        throw new \Exception('GHL contact creation failed: ' . $response->body());
    }

    public function createAppointment(Appointment $appointment): void
    {
        if (empty($this->apiKey) || empty($appointment->ghl_contact_id)) {
            return;
        }

        $datetime = $appointment->appointment_date->format('Y-m-d')
            . 'T' . $appointment->appointment_time . ':00';

        Http::withHeaders([
            'Authorization' => "Bearer {$this->apiKey}",
            'Content-Type'  => 'application/json',
        ])->post("{$this->baseUrl}/appointments/", [
            'locationId' => $this->locationId,
            'contactId'  => $appointment->ghl_contact_id,
            'startTime'  => $datetime,
            'title'      => $appointment->service->name ?? 'Spa Appointment',
            'notes'      => $appointment->notes,
        ]);
    }
}
