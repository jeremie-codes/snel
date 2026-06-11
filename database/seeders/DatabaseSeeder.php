<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::factory()->admin()->create([
            'name' => 'Administrateur',
            'email' => 'admin@example.com',
            'username' => 'admin',
            'password' => bcrypt('password'),
        ]);

        $agent = User::factory()->agent()->create([
            'name' => 'Agent Caisse',
            'email' => 'agent@example.com',
            'username' => 'agent',
            'password' => bcrypt('password'),
        ]);

        $client = Client::factory()->create([
            'user_id' => $agent->id,
            'name' => 'Client Demo',
            'email' => 'client@example.com',
            'reference' => 'CLI-0001',
        ]);

        Payment::factory()
            ->count(3)
            ->for($client)
            ->for($agent, 'agent')
            ->sequence(
                ['invoice_number' => 'FAC-2026-001', 'amount' => 100, 'currency' => 'USD', 'payment_method' => 'cash'],
                ['invoice_number' => 'FAC-2026-001', 'amount' => 75, 'currency' => 'USD', 'payment_method' => 'bank_transfer'],
                ['invoice_number' => 'FAC-2026-001', 'amount' => 25, 'currency' => 'CDF', 'payment_method' => 'mobile_money'],
            )
            ->create();
    }
}
