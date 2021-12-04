<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use App\Models\Idea;
use App\Notifications\IdeaCommentAdded;
use Livewire\Component;

class AddComment extends Component
{
    public $idea;

    public $comment;

    protected $rules = [
        "comment" => "required|min:4"
    ];

    public function mount(Idea $idea){
        $this->idea = $idea;
    }

    public function addComment()
    {
        auth()->guest() && abort(403);
        $this->validate();
        
        $newComment = Comment::create([
            "user_id" => auth()->id(),
            "idea_id" => $this->idea->id,
            "body" => $this->comment
        ]);
        (int) $this->idea->user_id !== (int) auth()->id() && $this->idea->user->notify(new IdeaCommentAdded($newComment));
        $this->emit("commentWasPosted", "Comment was posted!");
        $this->reset("comment");
    }

    public function render()
    {
        return view('livewire.add-comment');
    }
}