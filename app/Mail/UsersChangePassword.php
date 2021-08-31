<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UsersChangePassword extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $from = (env('MAIL_FROM_ADDRESS')) ? env('MAIL_FROM_ADDRESS') : "tiger-app@test.bg";
        $baseUrl = (env('APP_URL')) ? env('APP_URL') : "http://tiger-app-mvr.test/";
        if(substr($baseUrl, -1) != "/") $baseUrl .= "/";

        return $this->from($from)
                    ->subject('Създаване на потребителски профил')
                    ->markdown('users.change-password', ['user' => $this->user, 'url' => $baseUrl."auth/password/user-change/".$this->user->id]);
    }
}
