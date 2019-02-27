<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendToAdmin extends Mailable
{
    use Queueable, SerializesModels;

    protected $title;
    protected $text;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject = 'テスト', $content = 'コンテント')
    {
        $this->title = $subject;
        $this->text = $content;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->text('email.send_to_admin')
                    ->subject($this->title)
                    ->with([
                        'text' => $this->text
                    ]);
    }
}
