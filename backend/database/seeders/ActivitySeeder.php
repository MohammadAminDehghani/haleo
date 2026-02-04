<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        if ($users->isEmpty()) {
            $users = User::factory(5)->create();
        }

        foreach ($users as $user) {
            Activity::factory(rand(4, 10))->create([
                'user_id' => $user->id,
            ]);
        }
    }
}

