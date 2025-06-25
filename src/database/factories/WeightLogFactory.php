<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class WeightLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'date' => $this->faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
            'weight' => $this->faker->randomFloat(1, 40, 120), // 40.0〜120.0の範囲の体重
            'calories' => $this->faker->numberBetween(1000, 3000),
            'exercise_time' => $this->faker->numberBetween(0, 180), // 分
            'exercise_content' => $this->faker->randomElement(['ランニング', '筋トレ', 'ヨガ', '水泳', 'ウォーキング']),
        ];
    }
}
