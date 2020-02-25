<?php

namespace Tests\Unit;

use App\Task;
use App\TaskUser;
use App\User;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class TaskTest extends TestCase
{
    public function test_can_create_task()
    {
        $faker = \Faker\Factory::create();
        $data = [
            'title' => $faker->sentence,
            'description' => $faker->paragraph,
            'is_compulsory' => false,
            'start_at' => null,
            'end_at' => null
        ];

        $user = factory(User::class)->create();
        $token = JWTAuth::fromUser($user);
        $url = url('api' . route('tasks.store', ['token' => $token], false));

        $this->post($url, $data)->assertStatus(201)
            ->assertJson($data);
    }

    public function test_can_update_task()
    {
        $faker = \Faker\Factory::create();

        $user = factory(User::class)->create();

        $task = factory(Task::class)->create(['user_id' => $user->id]);
        $data = [
            'title' => "Changed",
            'description' => $faker->paragraph,
            'is_compulsory' => false,
            'start_at' => null,
            'end_at' => null
        ];


        $token = JWTAuth::fromUser($user);
        $url = url('api' . route('tasks.update', ['task' => $task->id, 'token' => $token], false));
        $this->put($url, $data)
            ->assertStatus(200)
            ->assertJson($data);
    }

    public function test_can_show_task()
    {
        $user = factory(User::class)->create();
        $task = factory(Task::class)->create(['user_id' => $user->id]);
        $token = JWTAuth::fromUser($user);
        $url = url('api' . route('tasks.show', ['task' => $task->id, 'token' => $token], false));

        $this->get($url)
            ->assertStatus(200);
    }

    public function test_can_destroy_task()
    {
        $user = factory(User::class)->create();
        $task = factory(Task::class)->create(['user_id' => $user->id]);
        $token = JWTAuth::fromUser($user);
        $url = url('api' . route('tasks.update', ['task' => $task->id, 'token' => $token], false));

        $this->delete($url)
            ->assertStatus(204);
    }

    public function test_can_list_tasks()
    {
        $user = factory(User::class)->create();

        $tasks = factory(Task::class, 2)->create(['user_id' => $user->id])->map(function ($task) {
            return $task->only(['id', 'title', 'description', 'is_compulsory', 'user_id', 'start_at', 'end_at']);
        });

        foreach ($tasks as $task) {
            factory(TaskUser::class)->create([
                'task_id' => $task['id'],
                'user_id' => $user->id
            ]);
        }

        $token = JWTAuth::fromUser($user);
        $url = url('api' . route('tasks.index', ['token' => $token], false));

        $this->get($url)
            ->assertStatus(200)
            ->assertJson($tasks->toArray())
            ->assertJsonStructure([
                '*' => ['id', 'title', 'description', 'is_compulsory', 'user_id', 'start_at', 'end_at'],
            ]);
    }
}