<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
//return view('emails.greeting');
Route::get('/', function () {
    \Illuminate\Support\Facades\Http::post('https://api.telegram.org/bot6768671724:AAGmTyvsrHuNguqSadzrFVgc3KHTHW0uxtE
/sendMessage', [
        'chat_id' => 800670294,
        'text' => 'Привет от бота'
    ])->json();
});



