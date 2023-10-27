<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SparePartAdPayRecieved extends Mailable
{
    use Queueable, SerializesModels;

    public $pay_data = null;
    public $pay_template = null;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($pay_data,$pay_template)
    {
        $this->pay_data = $pay_data;
        $this->pay_template = $pay_template;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
       $pay_data = $this->pay_data;
       $pay_template = $this->pay_template;
       $subject = str_replace('[[ads_title]]', $pay_data['title'], $pay_template->subject);
        return $this->subject($subject)->view('users.emails.spare_part_pay_recieved',compact('pay_data','pay_template'));
    }
}
