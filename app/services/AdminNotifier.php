<?php

namespace App\Services;

use App\Models\AdminNotification;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AdminNotifier
{
    public static function send(string $type, string $title, string $message, ?string $link = null): void
    {
        // 1. Simpan ke database (bell admin)
        AdminNotification::create([
            'type'    => $type,
            'title'   => $title,
            'message' => $message,
            'link'    => $link,
        ]);

        // 2. Email
        self::sendEmail($title, $message);

        // 3. WhatsApp
        self::sendWhatsApp($title . "\n\n" . $message);
    }

    protected static function sendEmail(string $title, string $message): void
    {
        $to = config('warso.admin_email');
        if (!$to) {
            return;
        }

        try {
            Mail::raw($message, function ($mail) use ($to, $title) {
                $mail->to($to)->subject('[Warso] ' . $title);
            });
        } catch (\Throwable $e) {
            Log::warning('Gagal kirim email admin: ' . $e->getMessage());
        }
    }

    protected static function sendWhatsApp(string $text): void
    {
        $token  = config('warso.fonnte_token');
        $target = config('warso.wa_admin');

        if (!$token || !$target) {
            return; // skip jika belum diset
        }

        try {
            Http::withHeaders([
                'Authorization' => $token,
            ])->post('https://api.fonnte.com/send', [
                'target' => $target,
                'message' => $text,
            ]);
        } catch (\Throwable $e) {
            Log::warning('Gagal kirim WA admin: ' . $e->getMessage());
        }
    }
}