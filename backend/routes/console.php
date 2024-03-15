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
   \Illuminate\Support\Facades\Http::post('https://api.telegram.org/bot6412690627:AAFAe49UxHM6yXxD8ExsKp4tENkaRNa6J_c/setWebhook?url=https://c2ab-95-55-139-139.ngrok-free.app');
})->purpose('Display an inspiring quote');
