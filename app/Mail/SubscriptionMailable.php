<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SubscriptionMailable extends Mailable
{
    use Queueable, SerializesModels;

     public $template = null;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($template)
    {
        $this->template = $template;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
          
        $template = $this->template;
        return $this->subject($template->subject)->view('users.emails.customer_subscription_mail',compact('template'));
    }
}
