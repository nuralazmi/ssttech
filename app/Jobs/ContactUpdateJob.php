<?php

namespace App\Jobs;

use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ContactUpdateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $details;

    public function __construct($details)
    {
        $this->details = $details;
    }


    public function handle()
    {
        Contact::find($this->details['id'])
            ->update($this->details);
    }
}
