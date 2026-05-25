<?php

namespace App\Console\Commands;

use App\Models\Appointment;
use App\Models\SiteSetting;
use App\Services\WhatsAppNotifier;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendAppointmentReminders extends Command
{
    protected $signature = 'appointments:send-reminders';

    protected $description = 'Send WhatsApp appointment reminder messages (template 3)';

    public function handle(WhatsAppNotifier $notifier): int
    {
        $config = SiteSetting::whatsappApi();

        if (! $notifier->isEnabled() || ! ($config['reminder_enabled'] ?? false)) {
            $this->info('WhatsApp reminders disabled or API not configured.');

            return self::SUCCESS;
        }

        $hoursBefore = max(1, min(168, (int) ($config['reminder_hours'] ?? 24)));
        $sent = 0;

        Appointment::query()
            ->with('service:id,name')
            ->whereIn('status', ['pending', 'confirmed'])
            ->whereNull('whatsapp_reminder_sent_at')
            ->whereDate('appointment_date', '>=', now()->toDateString())
            ->chunkById(50, function ($appointments) use ($notifier, $hoursBefore, &$sent) {
                foreach ($appointments as $appointment) {
                    if (! $this->shouldSendReminder($appointment, $hoursBefore)) {
                        continue;
                    }

                    if ($notifier->sendBookingReminder($appointment)) {
                        $appointment->update(['whatsapp_reminder_sent_at' => now()]);
                        $sent++;
                    }
                }
            });

        $this->info("Reminders sent: {$sent}");

        return self::SUCCESS;
    }

    private function shouldSendReminder(Appointment $appointment, int $hoursBefore): bool
    {
        $time = substr((string) $appointment->appointment_time, 0, 5);
        $appointmentAt = Carbon::parse($appointment->appointment_date->format('Y-m-d').' '.$time);
        $sendFrom = $appointmentAt->copy()->subHours($hoursBefore);
        $sendUntil = $sendFrom->copy()->addHour();

        return now()->between($sendFrom, $sendUntil) && now()->lt($appointmentAt);
    }
}
