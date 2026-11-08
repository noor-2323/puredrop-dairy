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
                    'name' => fake()->name(),
                    'phone' => fake()->phoneNumber(),
                    'source' => fake()->randomElement([
                        'Website',
                        'Facebook',
                        'Referral',
                        'Advertisement',
                    ]),
                    'status' => fake()->randomElement([
                        'new',
                        'contacted',
                        'qualified',
                        'converted',
                    ]),
                ]
            );
        }
    }
}