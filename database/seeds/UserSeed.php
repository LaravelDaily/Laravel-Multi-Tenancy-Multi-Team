<?php

use Illuminate\Database\Seeder;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            [
                'id' => 1,
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => '$2y$10$hbR8AKLXVktqi10Y04l/e.S/Ua8FtgOsUWXO7RBGOJ/SwcDnsZP9a',
                'role_id' => 1,
                'remember_token' => '',
                ],
        ];

        foreach ($items as $item) {
            \App\User::create($item);
        }
    }
}
