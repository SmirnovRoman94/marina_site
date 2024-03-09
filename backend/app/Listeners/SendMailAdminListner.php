<?php

namespace App\Listeners;

use App\Events\SendMailAdminEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendMailAdminListner
{

    public function handle(SendMailAdminEvent $event): void
    {
        $email = 'smirnow3217831@gmail.com';
        $user = $event->user;
        $servicesItems = $event->servicesItems;
        $user->services = $servicesItems ?? [];
        if (!empty($servicesItems)) {
            foreach ($servicesItems as $item) {
                $user->allPrice = $user->allPrice + $item->price;
            }
        }

        $mailable = new class($user) extends Mailable {
            public $user;

            public function __construct($user)
            {
                $this->user = $user;
            }
            public function build()
            {
                return $this->subject('Новая покупка')
                    ->view('emails.newServiceAdmin');
            }
        };

        Mail::to($email)->send($mailable);
    }
}
