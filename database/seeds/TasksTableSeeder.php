<?php

use App\Task;
use App\TaskUser;
use App\User;
use Illuminate\Database\Seeder;

class TasksTableSeeder extends Seeder
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
        $n = 250;
        $users = User::all();
        $admin_id = User::whereRoleId(1)->value('id');
        $status = ['pending', 'active', 'completed'];
        foreach (range(1, $n) as $i) {
            $is_compulsory = $i % 4 === 0; // Set random tasks as compulsory
            $user_id = User::inRandomOrder()->value('id');

            // Create tasks
            $task = Task::create([
                'title' => $faker->realText(40),
                'description' => $faker->realText(400),
                'is_compulsory' => $is_compulsory ? $faker->boolean : false,
                'start_at' => $faker->dateTimeBetween('-2 weeks', 'now'),
                'end_at' => $faker->dateTimeBetween('now', '+1 month'),
                'user_id' => $is_compulsory ? $admin_id : $user_id
            ]);

            // Assign to users
            TaskUser::create([
                'task_id' => $task->id,
                'user_id' => $user_id,
                'status' => $faker->randomElement($status)
            ]);
        }

        // Share compulsory tasks among users
        $compulsoryTasks = Task::whereIsCompulsory(1)->limit(intval(0.0625 * $n))->pluck('id');
        foreach ($compulsoryTasks as $task) {
            $users = User::inRandomOrder()->limit(5)->pluck('id');
            foreach ($users as $user) {
                TaskUser::create([
                    'task_id' => $task,
                    'user_id' => $user,
                    'status' => $faker->randomElement($status)
                ]);
            }
        }


    }
}
