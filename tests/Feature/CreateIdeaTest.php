<?php

namespace Tests\Feature;

use App\Http\Livewire\CreateIdea;
use App\Models\Category;
use App\Models\Status;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class CreateIdeaTest extends TestCase
{
    use RefreshDatabase;
    
    
    public function test_create_idea_form_does_not_show_when_logged_out(){
        $response = $this->get(route("idea.index"));
        $response->assertSuccessful();
        $response->assertSee("Please login to post an idea.") ;
        $response->assertDontSee("Welcome to ideaboard. We would love to hear your suggestions!") ;
    }

    public function test_create_idea_form_does_show_when_logged_in(){
        $response = $this->actingAs(User::factory()->create())->get(route("idea.index"));
        $response->assertSuccessful();
        $response->assertSee("Welcome to ideaboard. We would love to hear your suggestions!") ;
        $response->assertDontSee("Please login to post an idea.") ;
    }

    public function test_main_page_contains_create_idea_form_livewire_component(){
        $this->actingAs(User::factory()->create())
        ->get(route("idea.index"))
        ->assertSeeLivewire("create-idea");
    }

    public function test_create_idea_form_validation_works(){
        Livewire::actingAs(User::factory()->create())
            ->test(CreateIdea::class)
            ->set("title", "")
            ->set("category", "")
            ->set("description", "")
            ->call("createIdea")
            ->assertHasErrors(["title", "category", "description"])
            ->assertSee("The title field is required");
    }

    public function test_creating_an_idea_works_correctly(){
        $user = User::factory()->create();

        $cateogryOne = Category::factory()->create(["name" => "Category 1"]);
        $categoryTwo = Category::factory()->create(["name" => "Category 2"]);

        $statusOpen = Status::factory()->create([
            "name" => "Open",
            "icon" => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 absolute top-1 left-1 text-yellow-500" fill="none" viewBox="0 0 24 24"              stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
            </svg>'
        ]);

        Livewire::actingAs($user)
            ->test(CreateIdea::class)
            ->set("title", "My first idea")
            ->set("category", $cateogryOne->id)
            ->set("description", "Description of my first idea")
            ->call("createIdea")
            ->assertHasNoErrors()
            ->assertRedirect("/")
            ->assertSee("Idea was posted succesfully!");

        //Checking in database
        $this->assertDatabaseHas('ideas', [
            "title" => "My first idea",
            "slug" => "my-first-idea"
        ]);

        //Checking in index page
        $response = $this->get(route("idea.index"));
        $response->assertSuccessful();
        $response->assertSee("My first idea");
        $response->assertSee("Description of my first idea");
    }
}