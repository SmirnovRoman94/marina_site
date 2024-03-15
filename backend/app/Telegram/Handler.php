<?php

namespace App\Telegram;

use DefStudio\Telegraph\Facades\Telegraph;
use DefStudio\Telegraph\Handlers\WebhookHandler;
use DefStudio\Telegraph\Keyboard\Button;
use DefStudio\Telegraph\Keyboard\Keyboard;

class Handler extends WebhookHandler
{
    public function hello()
    {
        $this->reply('привет это бот от Марины');
    }

    static public function sendNewOrder()
    {
        Telegraph::message("Новый Заказ")
            ->keyboard(Keyboard::make()->buttons([
                Button::make("👌Оплата прошла")->action("sendPay"),
                Button::make("🤚 Оплата не прошла")->action("noSendPay"),
            ])->chunk(1))->photo('https://yandex.ru/images/search?img_url=https%3A%2F%2Fwww.russiadiscovery.ru%2Fstorage%2Fresolutions%2Fbig%2Fdescription_details%2F6026%2Fimg_64b5a0f6764e6.jpg&lr=2&nl=1&pos=13&rpt=simage&source=morda&text=%D0%9A%D0%B0%D1%80%D0%B5%D0%BB%D0%B8%D1%8F%20%D0%97%D0%B8%D0%BC%D0%BE%D0%B9')->send();
    }

    public function sendPay(): void
    {
        $this->reply('Спасибо, оплата прошла');
    }

    public function noSendPay(): void
    {
        $this->reply('Спасибо, оплата НЕ прошла');
    }
//$bot = \DefStudio\Telegraph\Models\TelegraphBot::find(1);
//$bot->registerCommands([
//'sendPay' => 'seden pay',
//'noSendPay' => 'no send'
//])->send();
//}
