<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $faker = \Faker\Factory::create();
        // Create Administrator
        User::create([
            'name' => "Administrator",
            'role_id' => 1,
            'email' => "admin@taskmanager.com",
            'password' => bcrypt('password'),
            'email_verified_at' => date('Y-m-d')
        ]);

        // Create basic users
        foreach (range(1, 20) as $i) {
            User::create([
                'name' => "$faker->firstName $faker->lastName",
                'role_id' => 2,
                'email' => $faker->unique()->email,
                'password' => bcrypt('password'),
                'email_verified_at' => date('Y-m-d')
            ]);
        }
    }
}
