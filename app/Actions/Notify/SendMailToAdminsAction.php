<?php

namespace App\Actions\Notify;

use App\Models\Transaction;
use Illuminate\Mail\Mailable;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Mail;

class SendMailToAdminsAction
{
    public function execute(Mailable $mailable) : void
    {
        $adminUsers = Role::findByName('Super admin', 'web')->users;

        foreach ($adminUsers->pluck('email')->all() as $recipient) {
            Mail::to($recipient)->send($mailable);
        }
    }
}
