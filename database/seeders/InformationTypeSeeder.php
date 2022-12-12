<?php

namespace Database\Seeders;

use App\Models\InformationType;
use Illuminate\Database\Seeder;

class InformationTypeSeeder extends Seeder
{
    public function run()
    {
        $types = ['email', 'phone', 'location'];
        foreach ($types as $item) {
            $information_type = new InformationType();
            $information_type->name = $item;
            $information_type->save();
        }
    }
}
