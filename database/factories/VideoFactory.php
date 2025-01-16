<?php

namespace Database\Factories;
use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Factory;

class VideoFactory extends Factory
{
    protected $model = Video::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'url' => 'https://www.youtube.com/watch?v=' . $this->faker->regexify('[A-Za-z0-9_-]{11}'),
            'published_at' => $this->faker->dateTimeThisYear,
            'previous' => null,
            'next' => null,
            'series_id' => null,
        ];
    }
}
