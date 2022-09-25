<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $title = $this->faker->unique()->sentence(4),
            'slug' => Str::slug($title) . '-' . time(),
            'summary' => $this->faker->unique()->sentence(10),
            'content' => $this->faker->unique()->sentence(41),
            'thumbnail' => $this->createImage(),
            'created_by' => User::query()->inRandomOrder()->first()->id,
            'created_at' => $this->faker->dateTimeBetween('-1 year', '-6 month'),
            'updated_at' => $this->faker->dateTimeBetween('-5 month', 'now'),
        ];
    }

    public function createImage()
    {
        try {
            // $image = file_get_contents('https://picsum.photos/720/420');
            $image = file_get_contents('https://placekitten.com/720/420');
            $filename = "thumbnail/" . Str::uuid() . '.jpg';

            Storage::disk('public')->put($filename, $image);

            return $filename;
        } catch (\Throwable $exception) {
            return null;
        }
    }
}
