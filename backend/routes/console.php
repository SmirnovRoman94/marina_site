<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('regBot', function () {
   \Illuminate\Support\Facades\Http::post('https://api.telegram.org/bot7014411218:AAFJc76pA5GILLAyTHz19EVhKWLn8MNp-mQ/setWebhook?url=https://34fih34j.org/api');
})->purpose('Display an inspiring quote');
