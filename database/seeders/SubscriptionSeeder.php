<?php

namespace Database\Seeders;

use App\Models\Subscription;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subscriptions = [
            [
                'name' => 'free',
                'price' => 0,
                'type' => 'free',
                'duration_in_days' => 0,
                'max_products' => 10,
            ],
            [
                'name' => '3 Months',
                'price' => 300,
                'type' => 'premium',
                'duration_in_days' => 90,
                'max_products' => 30,
            ],
            [
                'name' => '6 Months',
                'price' => 600,
                'type' => 'premium',
                'duration_in_days' => 180,
                'max_products' => 50,
            ],
            [
                'name' => '9 Months',
                'price' => 900,
                'type' => 'premium',
                'duration_in_days' => 270,
                'max_products' => 70,
            ],
            [
                'name' => 'Annual',
                'price' => 1100,
                'type' => 'premium',
                'duration_in_days' => 360,
                'max_products' => 100,
            ],
        ];

        foreach($subscriptions as $subscription) {

            Subscription::create($subscription);

        }
    }
}
