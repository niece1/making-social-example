<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => function () {
                return User::all()->random();
            },
            'body' => $this->faker->text(500),
            'type' => 'post',
            //'type' => ['post', 'repost', 'quote'][rand(0, 2)],
        ];
    }
}
