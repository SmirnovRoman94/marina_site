<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;

class SendMailAdminEvent
{
    use Dispatchable;

    public $user;
    public $file;
    public $servicesItems;


    public function __construct(User $user, string $file, array $servicesItems)
    {
        $this->user = $user;
        $this->file = $file;
        $this->servicesItems = $servicesItems;
    }

}
