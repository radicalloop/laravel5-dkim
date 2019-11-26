# laravel5-dkim
Sign outgoing emails with DKIM in early Laravel 5 versions

## Installation
1. Install via Composer:
```
composer require radicalloop/laravel5-dkim:dev-master
```
2. In `config/app.php`, comment out original service provider from `providers` array:
```
// Illuminate\Mail\MailServiceProvider::class,
```
3. In `config/app.php`, add following line to `providers` array:
```
RadicalLoop\LaravelDkim\DkimMailServiceProvider::class,
```
4. Fill your settings in `config/mail.php`:
```
'dkim_should_sign' => env('MAIL_DKIM_SHOULD_SIGN'), // yes / no, if set to no, signing is skipped. Useful for conditional signing.
'dkim_selector' => env('MAIL_DKIM_SELECTOR'), // selector, required
'dkim_domain' => env('MAIL_DKIM_DOMAIN'), // domain, required
'dkim_private_key' => env('MAIL_DKIM_PRIVATE_KEY'), // private key, required
'dkim_identity' => env('MAIL_DKIM_IDENTITY'), // identity, optional
'dkim_algo' => env('MAIL_DKIM_ALGO'), // sign algorithm (defaults to rsa-sha256), optional
'dkim_passphrase' => env('MAIL_DKIM_PASSPHRASE'), // private key passphrase, optional
```

TODO
----

* tests