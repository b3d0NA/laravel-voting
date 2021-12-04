<?php

namespace Tests\Feature;

use App\Http\Livewire\IdeaIndex;
use App\Http\Livewire\IdeaShow;
use App\Models\Category;
use App\Models\Idea;
use App\Models\Status;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class VoteShowPageTest extends TestCase
{
    use RefreshDatabase;
    
    function test_show_page_contains_idea_show_livewire_component(){
        $user = User::factory()->create();

        $categoryOne = Category::factory()->create(["name" => "Category 1"]);

        $statusOpen = Status::factory()->create([
            "name" => "Open",
            "icon" => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 absolute top-1 left-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
            </svg>'
        ]);

        $idea = Idea::factory()->create([
            "user_id" => $user->id,
            "title" => "Ajaira Polapain Thabra thabri",
            "category_id" => $categoryOne->id,  
            "status_id" => $statusOpen->id,
            "description" => "Ajaira Polapain Thabra thabri description",
        ]);

        $this->get(route("idea.show", $idea))
            ->assertSeeLivewire("idea-show");
    }

    public function test_if_user_getting_redirect_to_login_when_logged_out_while_voting(){
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

        Livewire::test(IdeaShow::class, [
                'idea' => $idea,
                'votesCount' => 5
            ])
            ->call("vote")
            ->assertRedirect(route("login"));
    }

    public function test_user_logged_in_can_vote_to_idea(){
        $user = User::factory()->create();

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

        Livewire::actingAs($user)
            ->test(IdeaShow::class, [
                'idea' => $idea,
                'votesCount' => 5
            ])
            ->call("vote")
            ->assertSet("votesCount", 6)
            ->assertSet("isVoted", true);
    }
}