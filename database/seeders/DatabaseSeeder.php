<?php

namespace Database\Seeders;
use App\Models\Blog;
use Illuminate\Support\Str;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
       Blog::create([
    'heading' => 'Test Blog',
    'slug' => Str::slug('Test Blog ' . now()->timestamp), // Makes slug unique
    'description' => 'This is a test blog post'
]);

// Or for multiple test blogs:
for ($i = 1; $i <= 10; $i++) {
    Blog::create([
        'heading' => 'Test Blog ' . $i,
        'slug' => 'test-blog-' . $i, // Unique slug for each
        'description' => 'This is test blog post #' . $i
    ]);
    }
}}
