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
            [   'id'                => 1, 
                'email'             => 'admin@admin.com', 
                'password'          => '123456',
                'role_id'           => 1,
                'employee_id'       => 0,
                'remember_token'    => '',
            ],
        ];

        foreach ($items as $item) {
            \App\User::create($item);
        }
    }
}
