<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\SiteSetting;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppNotifier
{
    public function isEnabled(): bool
    {
        $config = SiteSetting::whatsappApi();

        return $config['enabled'] && $config['token'] !== '' && $config['phone_number_id'] !== '';
    }

    public function sendBookingReceived(Appointment $appointment): bool
    {
        return $this->sendBooking($appointment, 'received');
    }

    public function sendBookingConfirmed(Appointment $appointment): bool
    {
        return $this->sendBooking($appointment, 'confirmed');
    }

    public function sendBookingReminder(Appointment $appointment): bool
    {
        if (! $this->isEnabled()) {
            return false;
        }

        $config = SiteSetting::whatsappApi();
        if (! ($config['reminder_enabled'] ?? false)) {
            return false;
        }

        $appointment->loadMissing('service:id,name');
        $template = $config['template_reminder'] ?: 'booking_reminder';

        return $this->sendTemplate(
            $appointment->client_phone,
            $template,
            $config['template_lang'],
            [
                $appointment->client_name,
                'تذكير بموعدك',
                $appointment->service?->name ?? 'خدمة',
                $appointment->appointment_date->format('Y/m/d'),
                substr((string) $appointment->appointment_time, 0, 5),
                '#'.str_pad((string) $appointment->id, 4, '0', STR_PAD_LEFT),
            ]
        );
    }

    public function sendTestMessage(string $phone, string $clientName = 'اختبار', string $templateType = 'received'): bool
    {
        $config = SiteSetting::whatsappApi();

        $templates = [
            'received' => [$config['template_received'] ?: 'booking_received', 'تم استلام حجزك'],
            'confirmed' => [$config['template_confirmed'] ?: 'booking_confirmed', 'تم تأكيد حجزك'],
            'reminder' => [$config['template_reminder'] ?: 'booking_reminder', 'تذكير بموعدك'],
        ];
        [$template, $statusLine] = $templates[$templateType] ?? $templates['received'];

        return $this->sendTemplate(
            $phone,
            $template,
            $config['template_lang'],
            [
                $clientName,
                $statusLine,
                'جلسة تجريبية',
                now()->format('Y/m/d'),
                now()->format('H:i'),
                'TEST',
            ]
        );
    }

    private function sendBooking(Appointment $appointment, string $type): bool
    {
        if (! $this->isEnabled()) {
            return false;
        }

        $appointment->loadMissing('service:id,name');

        $config = SiteSetting::whatsappApi();
        $template = $type === 'confirmed'
            ? ($config['template_confirmed'] ?: 'booking_confirmed')
            : ($config['template_received'] ?: 'booking_received');

        $statusLine = $type === 'confirmed'
            ? 'تم تأكيد حجزك'
            : 'تم استلام حجزك';

        return $this->sendTemplate(
            $appointment->client_phone,
            $template,
            $config['template_lang'],
            [
                $appointment->client_name,
                $statusLine,
                $appointment->service?->name ?? 'خدمة',
                $appointment->appointment_date->format('Y/m/d'),
                substr((string) $appointment->appointment_time, 0, 5),
                '#'.str_pad((string) $appointment->id, 4, '0', STR_PAD_LEFT),
            ]
        );
    }

    private function sendTemplate(string $phone, string $templateName, string $lang, array $bodyParams): bool
    {
        $config = SiteSetting::whatsappApi();
        $to = SiteSetting::normalizePhone($phone);

        if (strlen($to) < 10) {
            Log::warning('WhatsApp: invalid phone', ['phone' => $phone]);

            return false;
        }

        $parameters = array_map(fn ($text) => [
            'type' => 'text',
            'text' => (string) $text,
        ], $bodyParams);

        $version = $config['api_version'] ?: 'v21.0';
        $url = "https://graph.facebook.com/{$version}/{$config['phone_number_id']}/messages";

        try {
            $response = Http::withToken($config['token'])
                ->timeout(20)
                ->post($url, [
                    'messaging_product' => 'whatsapp',
                    'to'                  => $to,
                    'type'                => 'template',
                    'template'            => [
                        'name'     => $templateName,
                        'language' => ['code' => $lang ?: 'ar'],
                        'components' => [
                            [
                                'type'       => 'body',
                                'parameters' => $parameters,
                            ],
                        ],
                    ],
                ]);

            if ($response->successful()) {
                return true;
            }

            Log::warning('WhatsApp API error', [
                'status' => $response->status(),
                'body'   => $response->body(),
                'to'     => $to,
                'template' => $templateName,
            ]);
        } catch (\Throwable $e) {
            Log::error('WhatsApp send failed: '.$e->getMessage(), [
                'to' => $to,
                'template' => $templateName,
            ]);
        }

        return false;
    }
}
