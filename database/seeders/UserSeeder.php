<?php

namespace Database\Seeders;

use App\Models\MicrosoftAccount;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'user' => [
                    'name' => 'Admin',
                    'email' => 'admin@integration.example.com',
                    'email_verified_at' => now(),
                    'password' => bcrypt('password'),
                    'remember_token' => '',
                ],
                'microsoft_account' => [
                    'id' => 'ebdb351a-c8a4-4d54-8b67-18d09354f21b',
                    'email' => 'admin@M365x50814329.onmicrosoft.com'
                ],
            ],
            [
                'user' => [
                    'name' => 'Adele',
                    'email' => 'adele@integration.example.com',
                    'email_verified_at' => now(),
                    'password' => bcrypt('password'),
                    'remember_token' => '',
                ],
                'microsoft_account' => [
                    'id' => 'e2a9e7cf-52a3-407f-94a8-96f220bf41fc',
                    'email' => 'AdeleV@M365x50814329.OnMicrosoft.com',
                ]
            ]
        ];

        foreach($data as $key => $val) {
            DB::transaction(function() use($val) {
                $user = new User();
                $user->fill($val['user']);
                $user->save();

                $microsoft = new MicrosoftAccount();
                $microsoft->fill([
                    'user_id' => $user->id,
                    'microsoft_id' => $val['microsoft_account']['id'],
                    'microsoft_email' => $val['microsoft_account']['email'],
                ]);
                $microsoft->save();
            });
        }
    }
}
