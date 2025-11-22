<?php

namespace App\Services;

use App\Mail\VerifyEmailMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class EmailService
{
    /**
     * Send an email and log the details.
     */
    public function sendEmail(string $email, string $subject, string $message, string $title)
    {
        try {
            // Mail Send
            Mail::to($email)->send(new VerifyEmailMail($subject, $title, $message));
        } catch (\Exception $e) {
            // Log any exceptions
            Log::error("Failed to send email to {$email}: " . $e->getMessage());
        }
    }
}
