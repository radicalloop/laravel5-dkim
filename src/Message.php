<?php

namespace RadicalLoop\LaravelDkim;

use Swift_Signers_DKIMSigner;

class Message extends \Illuminate\Mail\Message
{
    /**
     * @param $selector
     * @param $domain
     * @param $privateKey
     * @param $passphrase
     *
     * @return $this
     */
    public function attachDkim($selector, $domain, $privateKey, $passphrase = '')
    {
        $signer = new Swift_Signers_DKIMSigner($privateKey, $domain, $selector, $passphrase);
        $signer->setHashAlgorithm(config('mail.dkim_algo', 'rsa-sha256'));
        if (config('mail.dkim_identity')) {
            $signer->setSignerIdentity(config('mail.dkim_identity'));
        }

        // Issue #1 (https://github.com/academe/laraveldkim/issues/1) : ignore certain headers that cause end-to-end failure.
        $signer->ignoreHeader('Return-Path');
        $signer->ignoreHeader('Bcc');
        $signer->ignoreHeader('DKIM-Signature');
        $signer->ignoreHeader('Received');
        $signer->ignoreHeader('Comments');
        $signer->ignoreHeader('Keywords');
        $signer->ignoreHeader('Resent-Bcc');

        $this->swift->attachSigner($signer);

        return $this;
    }
}