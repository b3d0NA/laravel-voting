<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Idea;
use App\Models\Status;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        User::factory()->create([
            "name" => "Mirror Code",
            "email" => "mirrorcode@protonmail.com",
        ]);

        Category::factory()->create(["name" => "Category 1"]);
        Category::factory()->create(["name" => "Category 2"]);
        Category::factory()->create(["name" => "Category 3"]);
        Category::factory()->create(["name" => "Category 4"]);

        Status::factory()->create([
            "name" => "Open",
            "icon" => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 absolute top-1 left-1 text-yellow-500" fill="none" viewBox="0 0 24 24"              stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
            </svg>'
        ]);
        Status::factory()->create([
            "name" => "Considering",
            "icon" => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 absolute top-1 left-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>'
        ]);
        Status::factory()->create([
            "name" => "In Progress",
            "icon" => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 absolute top-1 left-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
            </svg>'
        ]);
        Status::factory()->create([
            "name" => "Implemented",
            "icon" => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 absolute top-1 left-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
            </svg>'
        ]);
        Status::factory()->create([
            "name" => "Closed",
            "icon" => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 absolute top-1 left-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>'
        ]);
        
        Idea::factory(100)->create();

        foreach(range(1, 100) as $user_id){
            foreach(range(1, 100) as $idea_id){
                if($idea_id % 2 === 0){
                    Vote::factory()->create([
                        "user_id" => $user_id,
                        "idea_id" => $idea_id
                    ]);
                }
            }
        }

        // Seeding comments

        foreach(Idea::all() as $idea){
            Comment::factory(5)->create(['idea_id' => $idea->id]);
        }
        
    }
}