<?php

namespace App\Mail;
use App\Models\User;
use App\Models\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


class EventMail extends Mailable
{
    use Queueable, SerializesModels;

    public $events;
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($events,User $user)
    {
        $this->events = $events;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Events Subscription')->view('mails.event-mail');

    }
}
