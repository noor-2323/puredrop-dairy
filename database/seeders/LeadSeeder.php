<?php

namespace Database\Seeders;

use App\Models\Lead;
use Illuminate\Database\Seeder;

class LeadSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            Lead::firstOrCreate(
                ['email' => "samplelead{$i}@puredrop.test"],
                [
                    'name' => "Sample Lead {$i}",
                    'phone' => "0300000000",
                    'source' => 'Website',
                    'status' => 'new',
                ]
            );
        }
    }
}