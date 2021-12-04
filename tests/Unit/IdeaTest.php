<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Idea;
use App\Models\Status;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IdeaTest extends TestCase
{
    use RefreshDatabase;

    function test_it_can_check_if_idea_is_voted_for_by_user(){
        $user = User::factory()->create();
        $userB = User::factory()->create();

        $categoryOne = Category::factory()->create(["name" => "Category 1"]);

        $statusOpen = Status::factory()->create([
            "name" => "Open",
            "icon" => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 absolute top-1 left-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
            </svg>'
        ]);
        
        $ideaOne = Idea::factory()->create([
            "title" => "Ajaira Polapain Thabra thabri",
            "category_id" => $categoryOne->id,
            "status_id" => $statusOpen->id,
            "description" => "Ajaira Polapain Thabra thabri description",
        ]);

        Vote::factory()->create([
            "user_id" => $user->id,
            "idea_id" => $ideaOne->id
        ]);
        
        $this->assertTrue($ideaOne->isVotedByUser($user));
        $this->assertFalse($ideaOne->isVotedByUser($userB));
        $this->assertFalse($ideaOne->isVotedByUser(null));
    }

    function test_user_can_vote_any_ideas(){
        $user = User::factory()->create();
        $userB = User::factory()->create();

        $categoryOne = Category::factory()->create(["name" => "Category 1"]);

        $statusOpen = Status::factory()->create([
            "name" => "Open",
            "icon" => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 absolute top-1 left-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
            </svg>'
        ]);
        
        $ideaOne = Idea::factory()->create([
            "title" => "Ajaira Polapain Thabra thabri",
            "category_id" => $categoryOne->id,
            "status_id" => $statusOpen->id,
            "description" => "Ajaira Polapain Thabra thabri description",
        ]);
        
        $this->assertFalse($ideaOne->isVotedByUser($user));
        $ideaOne->vote($user);
        $this->assertTrue($ideaOne->isVotedByUser($user));
    }

    function test_user_can_unvote_voted_ideas(){
        $user = User::factory()->create();

        $categoryOne = Category::factory()->create(["name" => "Category 1"]);

        $statusOpen = Status::factory()->create([
            "name" => "Open",
            "icon" => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 absolute top-1 left-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
            </svg>'
        ]);
        
        $ideaOne = Idea::factory()->create([
            "title" => "Ajaira Polapain Thabra thabri",
            "category_id" => $categoryOne->id,
            "status_id" => $statusOpen->id,
            "description" => "Ajaira Polapain Thabra thabri description",
        ]);

        Vote::factory()->create([
            "user_id" => $user->id,
            "idea_id" => $ideaOne->id
        ]);
        
        $this->assertTrue($ideaOne->isVotedByUser($user));
        $ideaOne->removeVote($user);
        $this->assertFalse($ideaOne->isVotedByUser($user));
    }
}