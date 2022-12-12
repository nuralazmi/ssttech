<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    public function run()
    {
        Contact::factory()
            ->hasPhones(2)
            ->hasEmails(2)
            ->hasLocations(2)
            ->count(100)
            ->create();
    }
}
