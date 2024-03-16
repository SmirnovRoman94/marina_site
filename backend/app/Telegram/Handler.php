<?php

namespace App\Telegram;

use App\Http\Controllers\Files\FileController;
use DefStudio\Telegraph\Facades\Telegraph;
use DefStudio\Telegraph\Handlers\WebhookHandler;
use DefStudio\Telegraph\Keyboard\Button;
use DefStudio\Telegraph\Keyboard\Keyboard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class Handler extends WebhookHandler
{
    public function hello()
    {
        $this->reply('привет это бот от Марины');
    }

    static public function sendNewOrder($file, $patient)
    {
        Telegraph::message("Новый Заказ")
            ->keyboard(Keyboard::make()->buttons([
                Button::make("👌Оплата прошла")->action("sendPay"),
                Button::make("🤚 Оплата не прошла")->action("noSendPay"),
            ])->chunk(1))->photo("https://34fih34j.org/api/files?name={$file}")->send();
    }

    public function sendPay(): void
    {
        $this->reply('Спасибо, оплата прошла');
    }

    public function noSendPay(): void
    {
        $this->reply('Спасибо, оплата НЕ прошла');
    }
}
