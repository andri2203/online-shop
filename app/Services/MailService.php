<?php

namespace App\Services;

use App\Mail\VerificationCodeMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class MailService
{
    private static function emailSend(string $to, $mailable): void
    {
        Mail::to($to)->send($mailable);
    }

    public static function mailCodeVerifySend(string $email): void
    {
        // 6 random angka
        $code = random_int(100000, 999999);

        // Menyimpan kode verifikasi ke session
        Session::put("verification_code_{$email}", [
            'code' => $code,
            'expires_at' => now()->addMinutes(10),
        ]);

        $mail = new VerificationCodeMail($code);
        self::emailSend($email, $mail);
    }
}
