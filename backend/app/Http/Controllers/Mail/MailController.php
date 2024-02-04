<?php

namespace App\Http\Controllers\Mail;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function sendMail(Request $request)
    {
        $email = $request->input('email');
        $name = $request->input('name');

        $mailable = new class($name) extends Mailable {
            public $name;

            public function __construct($name)
            {
                $this->name = $name;
            }

            public function build()
            {
                return $this->subject('Промокод на первую консультацуию')
                    ->view('emails.greeting');
            }
        };

        Mail::to($email)->send($mailable);

        return response()->json(['mess' => 1, 'data' => 'Email успешно отправлен!']);
    }
}
