<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class EmailService
{
    /**
     * Tekil e-posta gönder.
     * Bulk mail sistemiyle aynı format ve log yapısını kullanır.
     *
     * @return array{success: bool, message: string}
     */
    public static function sendTo(
        string $email,
        string $name,
        string $subject,
        string $body,
        array  $context = []
    ): array {
        try {
            Mail::send([], [], function ($message) use ($email, $name, $subject, $body) {
                $message->to($email, $name)
                    ->subject($subject)
                    ->html(nl2br(e($body)));
            });

            Log::info('Email sent', array_merge([
                'to'      => $email,
                'subject' => $subject,
            ], $context));

            return ['success' => true, 'message' => "{$name} adresine e-posta başarıyla gönderildi."];
        } catch (\Exception $e) {
            Log::error('Email failed', array_merge([
                'to'      => $email,
                'subject' => $subject,
                'error'   => $e->getMessage(),
                'class'   => get_class($e),
            ], $context));

            return ['success' => false, 'message' => 'E-posta gönderilemedi: ' . $e->getMessage()];
        }
    }
}
