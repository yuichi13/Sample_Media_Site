<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Notification extends Mailable
{
    use Queueable, SerializesModels;

    protected $title;
    protected $user_title;
    protected $email;
    protected $text;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name = 'テスト', $data = [])
    {
        $this->title = sprintf('%sさん、ありがとうございます。', $name);
        $this->user_title = $data['subject'];
        $this->email = $data['email'];
        $this->text = $data['content'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->text('email.notification')
                    ->subject($this->title)
                    ->with([
                        'subject' => $this->user_title,
                        'email' => $this->email,
                        'text' => $this->text
                    ]);
    }
}
