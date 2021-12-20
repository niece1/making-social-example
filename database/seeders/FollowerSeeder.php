<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Follower;

class FollowerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $followers = [
            [
                'id' => 1,
                'user_id' => 1,
                'following_id' => 2,
                'created_at' => '2020-02-24 22:34:18',
                'updated_at' => '2020-02-24 22:34:18',
            ],
            [
                'id' => 2,
                'user_id' => 2,
                'following_id' => 1,
                'created_at' => '2020-03-24 22:34:18',
                'updated_at' => '2020-04-24 22:34:18',
            ],
            [
                'id' => 3,
                'user_id' => 2,
                'following_id' => 3,
                'created_at' => '2021-02-02 22:34:18',
                'updated_at' => '2021-10-24 22:34:18',
            ],
            [
                'id' => 4,
                'user_id' => 1,
                'following_id' => 1,
                'created_at' => '2020-02-24 22:34:18',
                'updated_at' => '2020-02-24 22:34:18',
            ],
        ];
        Follower::insert($followers);
    }
}
