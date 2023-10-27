<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CronJobTest extends Mailable
{
    use Queueable, SerializesModels;

    public $data = null;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
       $data = $this->data;
       return $this->subject('Cron Job Test')->view('users.emails.cron_job_mail',compact('data'));
    }
}