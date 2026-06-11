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
        User::factory()->admin()->create([
            'name' => 'Nom admin',
            'point_vente' => 'Kinshasa',
            'username' => 'admin',
            'password' => bcrypt('password'),
        ]);

        for ($i = 0; $i < 9; $i++) {
            User::factory()->agent()
                ->create(
                    ['name' => 'Nom agent ' . $i, 'point_vente' => 'Kinshasa', 'username' => 'agent' . $i, 'password' => bcrypt('password')]
                );
        }

        $names = [
            'Jean Robert',
            'Françoise Mukendi',
            'Bernard Kabongo',
            'John Doe',
            'Benois Ngaba',
        ];

        for ($i = 0; $i < 5; $i++) {
            Client::factory()->create([
                'user_id' => $i + 1,
                'reference' => 'CLI00000' . $i,
                'name' => $names[$i],
                'address' => '155, Kongolo, C/Kinshasa, Q/Djalo',
            ]);
        }

    }
}
