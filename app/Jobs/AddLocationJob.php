<?php

namespace App\Jobs;

use App\Models\Location;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AddLocationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $details;

    public function __construct($details)
    {
        $this->details = $details;
    }

    public function handle()
    {
        $location = new Location();
        $location->contact_id = $this->details['contact_id'];
        $location->city_id = $this->details['information_content'];
        $location->save();
    }
}
