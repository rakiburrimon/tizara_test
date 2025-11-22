<?php

namespace App\Jobs;

use App\Services\EmailService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\{InteractsWithQueue, SerializesModels};

class SendDefaultEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    protected $subject;
    protected $title;
    protected $message;
    protected $data;

    /**
     * Create a new job instance.
     *
     * @param string $email
     * @param string $subject
     * @param string $message
     * @param string $title
     */
    public function __construct(string $email, string $subject, string $message, string $title)
    {
        $this->email = $email;
        $this->subject = $subject;
        $this->message = $message;
        $this->title = $title;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(EmailService $emailService)
    {
        // Use the EmailService to send the email and log the details
        $emailService->sendEmail($this->email, $this->subject, $this->message, $this->title, $this->data);
    }
}
