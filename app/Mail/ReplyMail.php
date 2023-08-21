<?php

namespace App\Mail;

use App\Models\ContactUs;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReplyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $details;
    protected $contactUs;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    // public function __construct(ContactUs $contactUs)
    // {
    //     $this->$contactUs = $contactUs;
    // }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('reply-email-template');
    //     return $this->subject('Invitation')
    //     ->from(env('MAIL_FROM_ADDRESS','adnan.salahuddin@vultik.com'))
    //     ->markdown('reply-email-template')
    //     ->with([
    //         'first_name'  => $this->contactUs->first_name,
    //         'message' => $this->contactUs->message,
    // ]);
    }
}
