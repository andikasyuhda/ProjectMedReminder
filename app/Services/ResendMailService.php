<?php

namespace App\Services;

use Resend;
use Illuminate\Support\Facades\Log;

class ResendMailService
{
    protected $resend;

    public function __construct()
    {
        $apiKey = config('services.resend.api_key');
        if ($apiKey) {
            $this->resend = Resend::client($apiKey);
        }
    }

    /**
     * Send email using Resend API
     */
    public function send(array $data)
    {
        if (!$this->resend) {
            Log::warning('Resend API key not configured. Email not sent.');
            return false;
        }

        try {
            $response = $this->resend->emails->send([
                'from' => $data['from'] ?? config('mail.from.address'),
                'to' => $data['to'],
                'subject' => $data['subject'],
                'html' => $data['html'],
            ]);

            Log::info('Email sent via Resend', [
                'to' => $data['to'],
                'subject' => $data['subject'],
                'response' => $response
            ]);

            return $response;
        } catch (\Exception $e) {
            Log::error('Failed to send email via Resend', [
                'error' => $e->getMessage(),
                'to' => $data['to'],
                'subject' => $data['subject']
            ]);

            return false;
        }
    }

    /**
     * Send medication reminder email
     */
    public function sendMedicationReminder($user, $schedule, $scheduledTime)
    {
        $html = view('emails.medication-reminder-modern', [
            'user' => $user,
            'schedule' => $schedule,
            'scheduledTime' => $scheduledTime
        ])->render();

        return $this->send([
            'to' => [$user->email],
            'subject' => '⏰ Pengingat Minum Obat - ' . $schedule->medicine->name,
            'html' => $html
        ]);
    }
}
