<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Idea;
use App\Models\Status;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShowIdeasTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;

    public function test_ideas_can_view_from_index()
    {
        $categoryOne = Category::factory()->create(["name" => "Category 1"]);
        $categoryTwo = Category::factory()->create(["name" => "Category 2"]);

        $statusOpen = Status::factory()->create([
            "name" => "Open",
            "icon" => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 absolute top-1 left-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
            </svg>'
        ]);
        $statusConsidering = Status::factory()->create([
            "name" => "Considering",
            "icon" => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 absolute top-1 left-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>'
        ]);
        
        $ideaOne = Idea::factory()->create([
            "title" => "Ajaira Polapain Thabra thabri",
            "category_id" => $categoryOne->id,
            "status_id" => $statusOpen->id,
            "description" => "Ajaira Polapain Thabra thabri description",
        ]);
        
        $ideaTwo = Idea::factory()->create([
            "title" => "Mejaj khub gorom hoy",
            "category_id" => $categoryTwo->id,
            "status_id" => $statusConsidering->id,
            "description" => "Mejaj khub gorom hoy description",
        ]);

        $response = $this->get(route("idea.index"));

        $response->assertSuccessful();

        $response->assertSee($ideaOne->title);
        $response->assertSee($ideaOne->description);
        $response->assertSee($categoryOne->name);
        $response->assertSee('<span>Open</span>', false);

        $response->assertSee($ideaTwo->title);
        $response->assertSee($ideaTwo->description);
        $response->assertSee($categoryTwo->name);
        $response->assertSee('<span>Considering</span>', false);
    }

    public function test_single_idea_shows_on_idea_page(){
        $categoryOne = Category::factory()->create(["name" => "Category 1"]);

        $statusOpen = Status::factory()->create([
            "name" => "Open",
            "icon" => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 absolute top-1 left-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
            </svg>'
        ]);
        
        $idea = Idea::factory()->create([
            "title" => "Ajaira Polapain Thabra thabri",
            "category_id" => $categoryOne->id,
            "status_id" => $statusOpen->id,
            "description" => "Ajaira Polapain Thabra thabri description",
        ]);

        $response = $this->get(route("idea.show", $idea));

        $response->assertSuccessful();

        $response->assertSee($idea->title);
        $response->assertSee($idea->description);
        $response->assertSee($categoryOne->name);
        $response->assertSee('<span>Open</span>', false);
    }

    
}