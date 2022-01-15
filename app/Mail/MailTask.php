<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailTask extends Mailable
{
    use Queueable, SerializesModels;

    public $client;
    public $developer;
    public $task;
    public $project;
    public $datetime;
    public $status;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($client, $developer, $task, $project, $datetime, $status)
    {
        $this->client = $client;
        $this->developer = $developer;
        $this->task = $task;
        $this->project = $project;
        $this->datetime = $datetime;
        $this->status = $status;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.task');
    }
}
