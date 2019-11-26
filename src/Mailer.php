<?php

namespace RadicalLoop\LaravelDkim;

use Swift_Message;

class Mailer extends \Illuminate\Mail\Mailer
{
    protected function createMessage()
    {
        $message = new Message(new Swift_Message);

        // If a global from address has been specified we will set it on every message
        // instances so the developer does not have to repeat themselves every time
        // they create a new message. We will just go ahead and push the address.
        if (! empty($this->from['address'])) {
            $message->from($this->from['address'], $this->from['name']);
        }

        if ($this->shouldSignDKIM()) {
            if (in_array(strtolower(config('mail.driver')), ['smtp', 'sendmail', 'log'])) {
                if (config('mail.dkim_private_key') &&
                    config('mail.dkim_selector') &&
                    config('mail.dkim_domain')
                ) {
                    $message->attachDkim(
                        config('mail.dkim_selector'),
                        config('mail.dkim_domain'),
                        config('mail.dkim_private_key'),
                        config('mail.dkim_passphrase')
                    );
                }
            }
        }

        return $message;
    }

    private function shouldSignDKIM()
    {
        return (strtolower(config('mail.dkim_should_sign')) != 'no');
    }

}