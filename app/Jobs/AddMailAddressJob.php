<?php

namespace App\Jobs;

use App\Models\MailAddress;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AddMailAddressJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $detail;

    public function __construct($detail)
    {
        $this->detail = $detail;
    }

    public function handle()
    {
        $mail_address = new MailAddress();
        $mail_address->contact_id = $this->detail['contact_id'];
        $mail_address->email = $this->detail['information_content'];
        $mail_address->save();
    }
}
