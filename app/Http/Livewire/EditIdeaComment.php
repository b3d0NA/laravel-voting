<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use Livewire\Component;

class EditIdeaComment extends Component
{
    public $comment;
    public $body;

    protected $listeners = ["setEditComment"];

    protected $rules = [
        "body" => "required|min:4"
    ];

    public function setEditComment($commentId){
        $this->comment = Comment::findOrFail($commentId);
        $this->body = $this->comment->body;

        $this->emit("commentWasPlaced");        
    }

    public function updateComment()
    {
        (auth()->user()->cannot("update", $this->comment) || auth()->guest()) && abort(403);
        $this->validate();

        $this->comment->body = $this->body;
        $this->comment->save();

        $this->emit("commentWasUpdated", "Comment was updated!");
    }

    public function render()
    {
        return view('livewire.edit-idea-comment');
    }
}