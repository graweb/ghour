<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailProject extends Mailable
{
    use Queueable, SerializesModels;

    public $client;
    public $project;
    public $user;
    public $datetime;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($client, $project, $user, $datetime)
    {
        $this->client = $client;
        $this->project = $project;
        $this->user = $user;
        $this->datetime = $datetime;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.project');
    }
}
