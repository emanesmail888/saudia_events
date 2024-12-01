<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;


class ExpiredEventMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $ends_at;


    /**
     * Create a new message instance.
     *
     * @return void
     */
   
    public function __construct(User $user, $ends_at)
    {
        $this->user = $user;
        $this->ends_at = $ends_at;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Expired Subscription')->view('mails.event-expired-mail') ->with([
            'user' => $this->user,
            'ends_at' => $this->ends_at,
        ]);
       
    }
    
}
