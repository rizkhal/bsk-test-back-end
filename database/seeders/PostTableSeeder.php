<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PostTableSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $blogCategories = Category::factory()->count(20)->create();
        $this->command->info('Post category created.');

        Post::factory()->count(20)
            ->state(fn (array $attributes): array => [
                'category_id' => $blogCategories->random(1)->first()->id,
            ])
            ->create();

        $this->command->info('Post created.');
    }
}
