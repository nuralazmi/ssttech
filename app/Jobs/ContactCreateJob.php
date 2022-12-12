<?php

namespace App\Jobs;

use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ContactCreateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $details;

    public function __construct($details)
    {
        $this->details = $details;
    }

    public function handle()
    {
        $contact = new Contact();
        $contact->name = $this->details['name'];
        $contact->last_name = $this->details['last_name'];
        if (isset($this->details['company_id']))
            $contact->company_id = $this->details['company_id'];
        if (isset($this->details['photo']))
            $contact->photo = $this->details['photo'];

        if ($contact->save()) {
            $this->details['contact_id'] = $contact->id;
            $information_type = $this->details['information_type'];
            if ($information_type === 'phone')
                AddPhoneNumberJob::dispatch($this->details);
            elseif ($information_type === 'email')
                AddMailAddressJob::dispatch($this->details);
            else
                AddLocationJob::dispatch($this->details);
        }
    }
}
