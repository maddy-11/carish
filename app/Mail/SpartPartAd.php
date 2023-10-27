<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SpartPartAd extends Mailable
{
    use Queueable, SerializesModels;

    public $data = null;
    public $template = null;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data,$template)
    {
        $this->data = $data;
        $this->template = $template;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = $this->data;
        $template = $this->template;
        return $this->subject($template->subject)->view('users.emails.spart_part_ad_mail',compact('data','template'));
    }
}
